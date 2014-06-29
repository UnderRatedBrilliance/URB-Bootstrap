<?php namespace URB\Import\ImportProcessors;

class ShipworksOrderProcessor
{
	public function process($data)
	{
		$decodedData = json_decode($data->raw_json_data);

		$customer = $decodedData['Customer']['Address'][0];

		$customer = $this->getOrCreateCustomer($customer);

		$order = $decodedData['Customer']['Order'];
		$order = $this->getOrCreateOrder($rder);
	}

	public function getOrCreateCustomer($customerData)
	{
		$customer = App::make('URB\Customers\Customer');

		$customer = $customer->where('email',$customerData['Email'])->first();

		if(!$customer)
		{
			 	$customer = App::make('URB\Customers\Customer');
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

	public function getOrCreateOrder($orderData)
	{
		$order = App::make('URB\Orders\Orders');

		 //Find Order by shipworks order_id - if it does not exist create new order under customer 
       	$order = $order->where('shipworks_order_id',$orderData['Number'])->first();

        if(!$order) {
            $order = App::make('URB\Orders\Orders');
            $newOrder->shipworks_order_id        = $orderData['Number'];
            $newOrder->order_date                = date('Y-m-d',strtotime($orderData['Date']));

            $newOrder->ship_name                 = $orderData['Address'][0]['FirstName'].' '.$orderData['Address'][0]['LastName'];
            $newOrder->ship_address1             = $orderData['Address'][0]['Line1'];
            $newOrder->ship_address2             = $orderData['Address'][0]['Line2'];
            $newOrder->ship_address3             = $orderData['Address'][0]['Line3'];
            $newOrder->ship_city                 = $orderData['Address'][0]['City'];
            $newOrder->ship_state                = $orderData['Address'][0]['StateName'];
            $newOrder->ship_postal_code          = $orderData['Address'][0]['PostalCode'];
            $newOrder->ship_country_code         = $orderData['Address'][0]['CountryCode'];
            $newOrder->ship_phone                = $orderData['Address'][0]['phone'];

            $newOrder->bill_name                 = $orderData['Address'][1]['FirstName'].' '.$orderData['Address'][1]['LastName'];
            $newOrder->bill_address1             = $orderData['Address'][1]['Line1'];
            $newOrder->bill_address2             = $orderData['Address'][1]['Line2'];
            $newOrder->bill_address3             = $orderData['Address'][1]['Line3'];
            $newOrder->bill_city                 = $orderData['Address'][1]['City'];
            $newOrder->bill_state                = $orderData['Address'][1]['StateName'];
            $newOrder->bill_postal_code          = $orderData['Address'][1]['PostalCode'];
            $newOrder->bill_country_code         = $orderData['Address'][1]['CountryCode'];
            $newOrder->bill_phone                = $orderData['Address'][1]['phone'];

            $newOrder->order_source				 = 
            $newOrder->status                    = $this->resolveOrderStatus($order->local_status, $order->online_status);

            //Associate and Save Order to Customer
            $newOrder = $customer->orders()->save($newOrder);                
        }
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
}