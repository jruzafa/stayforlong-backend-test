<?php declare(strict_types=1);

namespace Stayforlong\Shared\Types\Domain;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Stayforlong\Shared\Types\Domain\Scalar\StringValue;

class Uuid extends StringValue
{
    public function __construct(string $value)
    {
        $this->ensuseIsValid($value);
        parent::__construct($value);
    }

    public static function random(): Uuid
    {
        return new Uuid(RamseyUuid::uuid4()->toString());
    }

    public static function randomValue(): string
    {
        return RamseyUuid::uuid4()->toString();
    }

    private function ensuseIsValid(string $id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }
}
