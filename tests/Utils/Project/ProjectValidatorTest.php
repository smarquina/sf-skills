<?php


namespace App\Tests\Utils\Project;

use App\Utils\Validator\Project\Validator;
use PHPUnit\Framework\TestCase;

class ProjectValidatorTest extends TestCase {
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    /**
     * @return void
     */
    public function testValidateName(): void
    {
        $test = 'project_test';

        $this->assertSame($test, $this->validator->validateName($test));
    }

    public function testValidateNameEmpty(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('The name can not be empty.');
        $this->validator->validateName(null);
    }

    public function testValidateNameInvalid(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('The name must contain only latin characters, numbers and underscores.');
        $this->validator->validateName('INVALID project');
    }

    public function testValidateAmount(): void
    {
        $test = '10000';

        $this->assertSame((int)$test, $this->validator->validateAmount($test));
    }

    public function testValidateAmountEmpty(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('The amount can not be empty.');
        $this->validator->validateAmount(null);
    }

    public function testValidateAmountInvalid(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Amount must be bigger than 1.');
        $this->validator->validateAmount('-1');
    }

    public function testValidateStartDate(): void
    {
        $test     = '01-12-2000';
        $testDate = \DateTime::createFromFormat("d-m-Y", $test);

        $this->assertSame($testDate->getTimestamp(),
                          $this->validator->validateStartDate($test)->getTimestamp());
    }

    public function testValidateStartDateEmpty(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('The start date can not be empty.');
        $this->validator->validateStartDate(null);
    }

    public function testValidateStartDateInvalid(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Date can\'t be parsed');
        $this->validator->validateStartDate('01/01/2000');
    }
}
