<?php namespace frontend\tests;

use frontend\models\ContactForm;

class Lesson3Test extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests expect()->.
    //- $this->assertTrue - сравнении с true
    //- $this->assertEquals - равно ожидаемому значению
    //- $this->assertLessThan - меньше ожидаемого значения
    //- $this->assertAttributeEquals - значение атрибута (свойства) объекта равно ожидаемому значению - создайте экземпляр ContactForm, заполните аттрибуты и проверьте, можно так тестировать, например массовую загрузку значений атрибутов.
    //- $this->assertArrayHasKey - в массиве есть указанный ключ
    public function testSimple()
    {
        $a = 20;
        $b = 30;
        expect($a)->equals(20);
        expect($a)->lessThan($b);
        $this->assertTrue($a < $b);
    }
    public function testArray()
    {
        $arr = [
            "city" => "Moscow",
            "phone" => 123
        ];

        expect($arr)->hasKey("city");
        expect($arr['city'])->equals('Moscow');
        expect($arr)->hasKey("phone");
    }
    public function testObject()
    {
        $object = new ContactForm();
        $object->name = "Вася";
        $object->email = "example@mail.com";
        $object->subject = "Test";
        $object->body = "Some text";
        $object->verifyCode = "dsfsdf";

        expect($object)->hasAttribute('name');
        expect($object->email)->equals("example@mail.com");
        $this->assertAttributeEquals("Test", 'subject', $object);


    }
}