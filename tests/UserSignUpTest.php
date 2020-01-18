<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\CreatesApplication;
use Faker\Generator as Faker;

class UserSignUpTest extends TestCase
{
    use CreatesApplication;

//getting the application instance
protected $app;
//faker instance for generating random data for testing
protected $faker;

    /**
     * @before
     */

protected function setapp(): void
{
   $this->app=$this->createApplication();
   $this->faker=$this->app->make('Faker\Generator');
   $this->assertInstanceOf('Faker\Generator',$this->faker);
}

    /**
     * A basic unit test example.
     *
     *
     * @codeCoverageIgnore
     */

    public function test_user_signup_success()
    {
        $request=$this->app->make('Illuminate\Http\Request');
        $request->request=new ParameterBag(array(
            'Name'=>$this->faker->name,
            'Email'=>$this->faker->email,
            'Password' => 'passing230',
            'Terms' =>true,
        ));
        $request->setMethod("POST");
        $UserController = new UserController();
        $status=$UserController->SignUp($request,$this->app->make('App\Models\User'));
        $this->assertEquals(200,$status->status(),"success");
    }

    public function Usershouldhaveuniqueemail(){
        $request=$this->app->make('Illuminate\Http\Request');
        $request->request=new ParameterBag(array(
            'Name'=>'testuser',
            'Email'=>'test@testersw.com',
            'Password' => 'passing230',
            'Terms' =>false,
        ));
        $request->setMethod("POST");
        $UserController = new UserController();
        $this->assertEquals($UserController->SignUp($request,$this->app->make('App\Models\User'))->status(),422);
    }



}
