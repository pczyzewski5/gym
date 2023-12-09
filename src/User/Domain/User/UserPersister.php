<?php

declare(strict_types=1);

namespace User\Domain\User;


use User\Domain\Exception\PersisterException;

interface UserPersister
{
    /**
     * @throws PersisterException
     */
    public function save(User $user): void;

    /**
     * @throws PersisterException
     */
    public function update(User $user): void;

    /**
     * @throws PersisterException
     */
    public function delete(User $user): void;
}
