<?php

namespace App\Domain\Account\Projectors;

use App\Domain\Account\Events\AccountCreated;
use App\Domain\Account\Events\AccountDeleted;
use App\Domain\Account\Events\MoneyAdded;
use App\Domain\Account\Events\MoneySubtracted;
use App\TransactionCount;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

final class TransactionCountProjector implements Projector
{
    use ProjectsEvents;

    public function onAccountCreated(AccountCreated $event, string $aggregateUuid)
    {
        TransactionCount::create([
            'uuid' => $aggregateUuid,
            'user_id' => $event->userId,
        ]);
    }

    public function onMoneyAdded(MoneyAdded $event, string $aggregateUuid)
    {
        TransactionCount::uuid($aggregateUuid)->incrementCount();
    }

    public function onMoneySubtracted(MoneySubtracted $event, string $aggregateUuid)
    {
        TransactionCount::uuid($aggregateUuid)->incrementCount();
    }

    public function onAccountDeleted(string $aggregateUuid)
    {
        TransactionCount::uuid($aggregateUuid)->delete();
    }
}
