<?php

namespace Tests\Feature\Core\UseCase\DividendPayment;

use App\Models\DividendPayment;
use App\Repositories\Eloquent\DividendPaymentEloquentRepository;
use Core\Domain\ValueObject\Date;
use Core\UseCase\DividendPayment\ListDividendPaymentUseCase;
use Core\UseCase\DTO\DividendPayment\DividendPaymentInputDto;
use Tests\TestCase;

class ListDividendPaymentTest extends TestCase
{
    use DividendPaymentFakersTrait;

    public function testList()
    {
        $this->createFakers();
        $payment = DividendPayment::factory()->create();

        $repository = new DividendPaymentEloquentRepository(new DividendPayment());
        $useCase = new ListDividendPaymentUseCase($repository);

        $response = $useCase->execute(new DividendPaymentInputDto($payment->id));

        $this->assertEquals($payment->id, $response->id);
        $this->assertEquals($payment->asset_id, $response->idAsset);
        $this->assertEquals(new Date($payment->payment_date), $response->paymentDate);
        $this->assertEquals($payment->fiscal_year, $response->fiscalYear);
        $this->assertEquals($payment->type, $response->type);
        $this->assertEquals($payment->amount, $response->amount);
        $this->assertEquals($payment->currency_id, $response->idCurrency);
    }
}
