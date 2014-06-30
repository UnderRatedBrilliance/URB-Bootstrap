<?php namespace URB\Import\ImportProcessors;

class ShipworksOrderProcessor
{

	public function process($data)
	{

        
		$decodedData = json_decode($data->raw_json_data,true);
        if(!$decodedData)
        {
           echo 'unable to process '.$data->id ."<br />";
            return false;
        }
        if($decodedData['Customer']['Order']['IsManual'] == 'true')
        {
            echo 'Is Manual Order unable to process '.$data->id ."<br />";
            return false;
        }
		$customer = $decodedData['Customer'];
        
		$customer = $this->getOrCreateCustomer($customer);

		$order = $decodedData['Customer']['Order'];
		$order = $this->getOrCreateOrder($order,$customer);

        $processingStatus = $this->processOrderItems($decodedData['Customer']['Order'],$order);

        if(!$processingStatus)
        {
            $data->errors = 'Unabled to process this order';
            $data->save();
            return false;
        }

        $data->status = true;
        $data->save();
        return true;
	}

	public function getOrCreateCustomer($customerData)
	{
		$customer = \App::make('URB\Customers\Customers');

        $customerEmail = $this->findCustomerEmail($customerData);

        if(!$customerEmail)
        {
            echo 'No Customer Email Found';
            return false;
        }
       
        
		$customer = $customer->where('email',$customerEmail)->first();

        $customerData = $customerData['Address'][1];

		if(!$customer)
		{
			 	$customer = \App::make('URB\Customers\Customers');
               	$customer->first_name			= $customerData['FirstName'];
               	$customer->last_name			= $customerData['LastName'];
               	$customer->middle_name			= $customerData['MiddleName'];
                $customer->email                = $customerData['Email'];
                $customer->address1             = $customerData['Line1'];
                $customer->address2             = $customerData['Line2'];
                $customer->address3             = $customerData['Line3'];
                $customer->city                 = $customerData['City'];
                $customer->state                = $customerData['StateCode'];
                $customer->postal_code          = $customerData['PostalCode'];
                $customer->country_code         = $customerData['CountryCode'];
                $customer->country_name 		= $customerData['CountryName'];
                $customer->phone                = $customerData['Phone'];
                $customer->fax 					= $customerData['Fax'];
                $customer->website				= $customerData['Website'];
                $customer->save();
		}
		return $customer;
	}

	public function getOrCreateOrder($orderData, $customer)
	{
		$order = \App::make('URB\Orders\Orders');

		 //Find Order by shipworks order_id - if it does not exist create new order under customer 
       	$order = $order->where('shipworks_order_id',$orderData['Number'])->first();

        if(!$order) {
            $order = \App::make('URB\Orders\Orders');
            $order->shipworks_order_id        = $orderData['Number'];
            $order->order_date                = date('Y-m-d',strtotime($orderData['Date']));

            $order->ship_name                 = $this->combineFirstAndLastName($orderData['Address'][0]['FirstName'],$orderData['Address'][0]['LastName']);
            $order->ship_address1             = $orderData['Address'][0]['Line1'];
            $order->ship_address2             = $orderData['Address'][0]['Line2'];
            $order->ship_address3             = $orderData['Address'][0]['Line3'];
            $order->ship_city                 = $orderData['Address'][0]['City'];
            $order->ship_state                = $orderData['Address'][0]['StateName'];
            $order->ship_postal_code          = $orderData['Address'][0]['PostalCode'];
            $order->ship_country_code         = $orderData['Address'][0]['CountryCode'];
            $order->ship_phone                = $orderData['Address'][0]['Phone'];

            $order->bill_name                 = $this->combineFirstAndLastName($orderData['Address'][1]['FirstName'],$orderData['Address'][1]['LastName']);
            $order->ship_address1             = $orderData['Address'][0]['Line1'];
            $order->ship_address2             = $orderData['Address'][0]['Line2'];
            $order->bill_address1             = $orderData['Address'][1]['Line1'];
            $order->bill_address2             = $orderData['Address'][1]['Line2'];
            $order->bill_address3             = $orderData['Address'][1]['Line3'];
            $order->bill_city                 = $orderData['Address'][1]['City'];
            $order->bill_state                = $orderData['Address'][1]['StateName'];
            $order->bill_postal_code          = $orderData['Address'][1]['PostalCode'];
            $order->bill_country_code         = $orderData['Address'][1]['CountryCode'];
            $order->bill_phone                = $orderData['Address'][1]['Phone'];

            $order->order_source			  = $this->resolveOrderSource($orderData);
            $order->status                    = $this->resolveOrderStatus($orderData['Status'],$orderData['OnlineStatus']);

            //Associate and Save Order to Customer
            return $order = $customer->orders()->save($order);                
        }
        return $order;
	}

	public function resolveOrderStatus($local_status,$online_status)
	{
		if($online_status == 'Canceled')
		{
			return false;
		}
		if($local_status == 'Canceled') 
		{
			return false;
		}
		return true;
	}

    public function resolveOrderSource($orderData)
    {
        if($orderData['@attributes']['storeID'] == '2005')
        {
            if(strpos($orderData['RequestedShipping'],'Amazon') !== false)
            {
                return 'Amazon';
            }
            return 'Magento';
        }
        if($orderData['@attributes']['storeID'] == '1005')
        {
            return 'eBay';
        }
        return 'Unknown';
    }

    public function processOrderItems($orderData,$order)
    {
        

        if(isset($orderData['Item']['SKU']))
        {
            $item = $this->getOrCreateItem($orderData['Item']);

            $orderItem = $this->getOrCreateOrderItem($orderData['Item'], $item, $order);

            if(!$orderItem)
            {
                return false;
            }
        }
        else {
            foreach($orderData['Item'] as $orderItem)
            {

                $item = $this->getOrCreateItem($orderItem);

                $orderItem = $this->getOrCreateOrderItem($orderItem, $item, $order);

                if(!$orderItem)
                {
                    return false;
                }
            }
        }
        
        return true;
    }

    public function getOrCreateItem($itemData)
    {
        $item = \App::make('URB\Items\Items');

       
        $item = $item->where('sku',$itemData['SKU'])->first();

        if(!$item) 
        {
            $item = \App::make('URB\Items\Items');

            $item->sku              = $itemData['SKU'];
            $item->name             = $itemData['Name'];
            $item->status           = true;
            $item->save();

        }
        return $item;
    }

    public function getOrCreateOrderItem($orderItemData, $item, $order)
    {
        $orderItem = \App::make('URB\Orders\OrderItems');

       
        $orderItem = $orderItem->where('sku',$orderItemData['SKU'])->where('shipworks_order_id',$order->shipworks_order_id)->first();

        if(!$orderItem) 
        {
            $orderItem = \App::make('URB\Orders\OrderItems');

            $orderItem->shipworks_order_id = $order->shipworks_order_id;
            $orderItem->name                = $orderItemData['Name'];
            $orderItem->sku                 = $orderItemData['SKU'];
            $orderItem->qty                 = $orderItemData['Quantity'];
            $orderItem->unit_price          = $orderItemData['UnitPriceWithOptions'];
            $orderItem->total               = $orderItemData['TotalPriceWithOptions'];
            $orderItem->order_id            = $order->id;
            $orderItem->item_id             = $item->id;

            $orderItem->save();

        }
        return $orderItem;
    }

    public function combineFirstAndLastName($firstName,$lastName)
    {
        $name = '';

        if(isset($firstName) AND !is_array($firstName)) 
        {
            $name = $firstName.' ';
        }
        if(isset($lastName) AND !is_array($lastName))
        {
            $name .= $lastName;
        }
        return $name;
    }

    public function findCustomerEmail($customerData)
    {

        if(!is_array($customerData['Address'][0]['Email']))
        {
            return $customerData['Address'][0]['Email'];
        }
        elseif(!is_array($customerData['Address'][1]['Email']))
        {
            return $customerData['Address'][1]['Email'];
        }
        elseif(!is_array($customerData['Order']['Address'][0]['Email']))
        {
            return $customerData['Order']['Address'][0]['Email'];
        }
        elseif(!is_array($customerData['Order']['Address'][1]['Email']))
        {
            return $customerData['Order']['Address'][1]['Email'];
        }
        return false;
    }
}