<?php

namespace Tests\Unit;

use App\Http\Controllers\CheckoutController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\CreatesApplication;

class CheckoutTest extends TestCase
{
    use CreatesApplication;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_count_data_from_checkout_table()
    {
            $request = $this->createApplication()->make('Illuminate\Http\Request');
            $request->request=new ParameterBag(array(
                'id'=>1
            ));
            $request->setMethod('POST');
            $controller  = new CheckoutController();
            $this->assertCount(6,$controller->InvoiceTable($request));
    }
}
