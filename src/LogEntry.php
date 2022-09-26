<?php

namespace App;

use Opis\ORM\{
    Entity, 
    IEntityMapper,
    IMappableEntity
};

use \DateTime;

class LogEntry extends Entity implements IMappableEntity {
    public function id(): int {
        return $this->orm()->getColumn('id');
    }

    public function creationTime(): DateTime {
        return $this->orm()->getColumn('creationTime');
    }

    public function setCreationTime(DateTime $val): self {
        $this->orm()->setColumn('creationTime', $val);
        return $this;
    }

    public function duration(): float {
        return $this->orm()->getColumn('duration');
    }

    public function setDuration(float $val): self {
        $this->orm()->setColumn('duration', $val);
        return $this;
    }

    public function paramX(): float {
        return $this->orm()->getColumn('paramX');
    }

    public function setParamX(float $val): self {
        $this->orm()->setColumn('paramX', $val);
        return $this;
    }

    public function paramY(): float {
        return $this->orm()->getColumn('paramY');
    }

    public function setParamY(float $val): self {
        $this->orm()->setColumn('paramY', $val);
        return $this;
    }

    public function paramR(): float {
        return $this->orm()->getColumn('paramR');
    }

    public function setParamR(float $val): self {
        $this->orm()->setColumn('paramR', $val);
        return $this;
    }

    public function result(): bool {
        return $this->orm()->getColumn('result');
    }

    public function setResult(bool $val): self {
        $this->orm()->setColumn('result', $val);
        return $this;
    }

    public static function mapEntity(IEntityMapper $mapper) {
        $mapper->cast([
            'id' => 'integer',
            'creationTime' => 'date'
        ]);
    }
}
