<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserQuery extends QueryBuilder
{
    public function findByEmail($email)
    {
        return static::whereEmail($email)->first();
    }

    public function withLastLogin()
    {
        $subselect = Login::select('logins.created_at')
            ->whereColumn('logins.user_id', 'users.id')
            ->latest()
            ->limit(1);

        return $this->addSelect([
            'last_login_at' => $subselect,
        ]);
    }

    public function withTeamOrNot($team) {
            if ($team === 'with_team') {
                $this->has('team');
            } elseif ($team === 'without_team') {
                $this->doesntHave('team');
            }
            return $this;

    }
}