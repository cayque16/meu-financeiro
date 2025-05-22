<?php

namespace Tests\Unit\UseCase\DividendPayment;

use Core\Domain\Entity\Asset;
use Core\Domain\Entity\AssetType;
use Core\Domain\Entity\Currency;
use Core\Domain\Entity\DividendPayment;
use Core\Domain\Enum\DividendType;
use Core\Domain\Repository\BaseRepositoryInterface;
use Core\Domain\Repository\DividendPaymentRepositoryInterface;
use Core\Domain\ValueObject\Date;
use Core\UseCase\DividendPayment\CreateDividendPaymentUseCase;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentInputDto;
use Core\UseCase\DTO\DividendPayment\Create\CreateDividendPaymentOutputDto;
use Core\UseCase\Exceptions\NotFoundException;
use DateTime;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateDividendPaymentUnitTest extends TestCase
{
    public function testCreate()
    {
        $idAsset = $this->getUuid();
        $asset = $this->mockAsset($idAsset);
        
        $idCurrency = $this->getUuid();
        $currency = $this->mockCurrency($idCurrency);

        $idDividend = $this->getUuid();
        $dividend = Mockery::mock(DividendPayment::class, [$asset, new Date(), DividendType::JCP, 250, $currency]);
        $dividend->shouldReceive("id")->andReturn($idDividend);
        $dividend->shouldReceive("date")->andReturn('date');
        $dividend->shouldReceive("isActive")->andReturn(true);
        $dividend->shouldReceive("createdAt")->andReturn(new Date());
        $dividend->shouldReceive("updatedAt")->andReturn(null);
        $dividend->shouldReceive("deletedAt")->andReturn(null);

        $repoDividendPayment = $this->mockRepo('insert', $dividend, interface: DividendPaymentRepositoryInterface::class);
        $repoAsset = $this->mockRepo('findById', $asset);
        $repoCurrency = $this->mockRepo('findById', $currency);


        $useCase = new CreateDividendPaymentUseCase($repoDividendPayment, $repoAsset, $repoCurrency);
        $response = $useCase->execute($this->mockInput($idAsset, $idCurrency));

        $this->assertInstanceOf(CreateDividendPaymentOutputDto::class, $response);
    }

    public function testAssetNotFound()
    {
        $repoDividendPayment = $this->mockRepo('insert', null, times: 0, interface: DividendPaymentRepositoryInterface::class);
        $repoAsset = $this->mockRepo('findById', null);
        $repoCurrency = $this->mockRepo('findById', null, times: 0);

        $useCase = new CreateDividendPaymentUseCase($repoDividendPayment, $repoAsset, $repoCurrency);

        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($this->mockInput("", ""));
    }

    public function testCurrencyNotFound()
    {
        $repoDividendPayment = $this->mockRepo('insert', null, times: 0, interface: DividendPaymentRepositoryInterface::class);
        $repoAsset = $this->mockRepo('findById', $this->mockAsset($this->getUuid()));
        $repoCurrency = $this->mockRepo('findById', null);

        $useCase = new CreateDividendPaymentUseCase($repoDividendPayment, $repoAsset, $repoCurrency);

        $this->expectException(NotFoundException::class);
        $response = $useCase->execute($this->mockInput("", ""));
    }

    private function mockAsset($idAsset)
    {
        $mockAsset = Mockery::mock(Asset::class, ['BTC', $this->mockType(), $idAsset]);
        $mockAsset->shouldReceive("id")->andReturn($idAsset);

        return $mockAsset;
    }

    private function mockType()
    {
        $mockType = Mockery::mock(AssetType::class, ['stock']);

        return $mockType;
    }

    private function mockCurrency($idCurrency)
    {
        $mockCurrency = Mockery::mock(
            Currency::class,
            ['Real', 'R$', 'BRL', 100, 2, $idCurrency, 'desc']
        );
        $mockCurrency->shouldReceive("id")->andReturn($idCurrency);

        return $mockCurrency;
    }

    private function getUuid()
    {
        $uuid = (string) Uuid::uuid4();

        return $uuid;
    }

    private function mockInput($idAsset, $idCurrency)
    {
        $mockInput = Mockery::mock(
            CreateDividendPaymentInputDto::class,
            [$idAsset, (new DateTime())->format('Y-m-d H:i:s'), DividendType::JCP, 250, $idCurrency]
        );

        return $mockInput;
    }

    private function mockRepo(
        $name,
        $return,
        $times = 1,
        $interface = BaseRepositoryInterface::class
    ) {
        $mockRepo = Mockery::mock(stdClass::class, $interface);
        $mockRepo->shouldReceive($name)
            ->times($times)
            ->andReturn($return);

        return $mockRepo;
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
