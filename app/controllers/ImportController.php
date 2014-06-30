<?php

class ImportController extends BaseController {

	public function getIndex()
	{
		return 'sucessful controller';
	}

	public function anyShipworks()
	{
		$contentToImport = $this->requestContent();

		if(!$contentToImport)
		{
			return array('error'=>'no content to import');
		}

		$data = json_decode($this->parseXmlToJson($contentToImport['raw_data']),true);

		$importHash = md5($data['Customer']['Order']['Number'].$data['Customer']['Order']['Date']);

		$import = App::make('URB\Import\Import');

		if(!$import->where('unique_hash',$importHash)->first())
		{
			$import->type = 'shipworks_order';
			$import->raw_json_data = $this->parseXmlToJson($contentToImport['raw_data']);
			$import->status = false;
			$import->unique_hash = $importHash;
			$import->save();
			return array('success'=>true);
		}
	}

	public function getProcessImport($type)
	{
		$processor = App::make("URB\Import\ImportProcessors\\".$type."Processor");

		$data = App::make("URB\Import\Import")->where('status',0)
		->where('type',snake_case($type))
		->chunk(200, function($importData) use ($processor){
			foreach ($importData as $data) {

				$status = $processor->process($data);

				if(!$status)
				{
					echo '<br/><br/>Import could not be processed for ID '.$data->id .'<br/>';

				}
			}
		});


		
	}

// Get Request Content 
	public function requestContent()
	{
		$content = array();

		$content['parameters'] = Input::all();

		$content['raw_data'] = Request::getContent();

		if($content['parameters'] OR $content['raw_data'])
		{
			return $content;
		}

		return null;
		
	}

	// Takes XML String returns returns json string
	public function parseXmlToJson($xml_string)
	{
		libxml_use_internal_errors(true);

		$doc = simplexml_load_string($xml_string);

		if(!$doc)
		{
			libxml_clear_errors();
			return false;
		}
		return json_encode($doc);
	}

	public function mergeJsonObjects($jsonObj1, $jsonObj2)
	{
		$array1 = json_decode($jsonObj1,true);
		$array2 = json_decode($jsonObj2,true);

		return json_encode($array_merge_recursive($array1,$array2));
	}
}
