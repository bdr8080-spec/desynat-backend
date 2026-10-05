<?php

namespace Tests\Feature;

use App\Models\WithdrawRequest;
use App\Services\SellerPayoutService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SellerPayoutServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (!Schema::hasTable('withdraw_requests')) {
            Schema::create('withdraw_requests', function (Blueprint $table) {
                $table->id();
                $table->string('request_id');
                $table->tinyInteger('type')->default(3);
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('bankdetails_id')->nullable();
                $table->string('amount')->default('0');
                $table->tinyInteger('admin_verify')->default(1);
                $table->string('transaction_id')->nullable();
                $table->dateTime('payment_receive_date')->nullable();
                $table->timestamps();
            });
            return;
        }

        if (!Schema::hasColumn('withdraw_requests', 'transaction_id')) {
            Schema::table('withdraw_requests', function (Blueprint $table) {
                $table->string('transaction_id')->nullable();
            });
        }

        if (!Schema::hasColumn('withdraw_requests', 'payment_receive_date')) {
            Schema::table('withdraw_requests', function (Blueprint $table) {
                $table->dateTime('payment_receive_date')->nullable();
            });
        }
    }

    public function test_it_includes_transaction_id_and_date_fields_in_payout_response(): void
    {
        WithdrawRequest::create([
            'request_id' => 'REQ-1001',
            'type' => 3,
            'user_id' => 1,
            'bankdetails_id' => 1,
            'amount' => '150.000',
            'admin_verify' => 1,
            'transaction_id' => 'TXN-1001',
            'payment_receive_date' => '2026-09-15 12:00:00',
            'created_at' => '2026-09-12 10:00:00',
            'updated_at' => '2026-09-15 12:00:00',
        ]);

        $service = new SellerPayoutService();
        $result = $service->getMyPayouts((object) [
            'seller_id' => 1,
            'limit' => 20,
            'from_date' => '2026-09-01',
            'to_date' => '2026-09-30',
            'search' => null,
        ]);

        $this->assertSame('success', $result['status']);
        $this->assertSame('2026-09-01', $result['data']['from_date']);
        $this->assertSame('2026-09-30', $result['data']['to_date']);

        $items = $result['data']['payouts']->items();
        $this->assertNotEmpty($items);
        $this->assertSame('TXN-1001', $items[0]['transaction_id']);
        $this->assertSame('2026-09-15 12:00:00', $items[0]['payment_receive_date']);
    }
}
