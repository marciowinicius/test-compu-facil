<?php
include_once 'CreditCard.php';

class CreditCardTest extends PHPUnit_Framework_TestCase {

	function testValidNumber() {
		$credit_card = new CreditCard();
		$this->assertTrue($credit_card->Set('4444333322221111'));
	}

	function testInvalidNumberShouldReturError() {
		$credit_card = new CreditCard();
		$this->assertEquals( 'ERROR_INVALID_LENGTH', $credit_card->Set('3333555522221111') );
	}

	function testValidNumberShouldSetAndGet() {
		$credit_card = new CreditCard();
		$credit_card->Set('4444333322221111');
		$this->assertEquals('4444333322221111',$credit_card->Get());
	}
}
