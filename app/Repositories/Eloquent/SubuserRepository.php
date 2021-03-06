<?php
/*
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Pterodactyl\Repositories\Eloquent;

use Webmozart\Assert\Assert;
use Pterodactyl\Models\Subuser;
use Pterodactyl\Exceptions\Repository\RecordNotFoundException;
use Pterodactyl\Contracts\Repository\SubuserRepositoryInterface;

class SubuserRepository extends EloquentRepository implements SubuserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function model()
    {
        return Subuser::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getWithServer($id)
    {
        Assert::numeric($id, 'First argument passed to getWithServer must be numeric, received %s.');

        $instance = $this->getBuilder()->with('server', 'user')->find($id, $this->getColumns());
        if (! $instance) {
            throw new RecordNotFoundException;
        }

        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function getWithPermissions($id)
    {
        Assert::numeric($id, 'First argument passed to getWithPermissions must be numeric, received %s.');

        $instance = $this->getBuilder()->with('permissions', 'user')->find($id, $this->getColumns());
        if (! $instance) {
            throw new RecordNotFoundException;
        }

        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function getWithServerAndPermissions($id)
    {
        Assert::numeric($id, 'First argument passed to getWithServerAndPermissions must be numeric, received %s.');

        $instance = $this->getBuilder()->with('server', 'permission', 'user')->find($id, $this->getColumns());
        if (! $instance) {
            throw new RecordNotFoundException;
        }

        return $instance;
    }
}
