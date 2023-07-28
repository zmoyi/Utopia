<?php

namespace App\Services;

use App\Models\MembershipLevel;
use App\Models\User;
use App\Models\UserMember;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\HigherOrderCollectionProxy;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * 获取全部角色
     * @return Collection
     */
    public function getRole(): Collection
    {
        return Role::query()->get()->pluck('name', 'name');
    }

    /**
     * 添加角色
     * @param int $userId
     * @param array $role
     * @return void
     */
    public function addRole(int $userId, array $role): void
    {
        User::query()->find($userId)->syncRoles($role);
    }

    /**
     * 获取会员级别
     * @return Collection
     */
    public function getMembershipLevel(): Collection
    {
        return MembershipLevel::query()->get()->pluck('name', 'id');
    }

    public function addUserMembers(Model|User $user, int $memberId): Model
    {
        $member = MembershipLevel::query()->find($memberId);
        $membership_level = $member->slug;
        $expiration_date = Carbon::now()->addDays($member->validity_period);
        $card_codes_quota = $member->card_codes_quota;

        return $user->member()->create([
            'membership_level' => $membership_level,
            'expiration_date' => $expiration_date,
            'card_codes_quota' => $card_codes_quota
        ]);
    }

    /**
     * 获取用户会员级别
     * @param int $userId
     * @param string $value
     * @return mixed
     */
    public function getUserMember(int $userId, string $value): mixed
    {
        return UserMember::query()->where('user_id', $userId)->value($value);
    }

    /**
     * 获取用户所有角色
     * @param int $userId
     * @return mixed
     */
    public function getUserRoles(int $userId): mixed
    {
        $user = User::query()->where('id', $userId)->first();
        return $user->getRoleNames();
    }

    /**
     * 根据slug获取会员级别
     * @param string $slug
     * @return Builder
     */
    public function getMembershipLevelBySlug(string $slug): Builder
    {
        return MembershipLevel::query()->where('slug', $slug);
    }

    /**
     * 获取用户会员级别名称
     * @param int $userId
     * @return Builder
     */
    public function getMemberName(int $userId): Builder
    {
        $slug = $this->getUserMember($userId, 'membership_level');
        return $this->getMembershipLevelBySlug($slug);
    }

    /**
     * 统一更新用户会员级别
     * @param Model|User $user
     * @param int $memberId
     * @return int
     */
    public function updateUserMember(Model|User $user, int $memberId): int
    {
        $member = MembershipLevel::query()->find($memberId);
        $membership_level = $member->slug;
        $expiration_date = Carbon::now()->addDays($member->validity_period);
        $card_codes_quota = $member->card_codes_quota;
        return $user->member()->update([
            'membership_level' => $membership_level,
            'card_codes_quota' => $card_codes_quota,
            'expiration_date' => $expiration_date,

        ]);
    }

    /**
     * 更新用户会员过期时间
     * @param Model|User $user
     * @param string $date
     * @return int
     */
    public function updateUserMemberExpirationDate(Model|User $user, string $date): int
    {
        return $user->member()->update([
            'expiration_date' => $date,
        ]);
    }

    /**
     * 更新用户卡密上限
     * @param Authenticatable|Model|User $user
     * @param string $quota
     * @return int
     */
    public function updateUserMemberCardCodesQuota(Authenticatable|Model|User $user, string $quota): int
    {
        return $user->member()->update([
            'card_codes_quota' => $quota,
        ]);
    }

    /**
     * 获取当前用户会员过期时间
     * @param Authenticatable|User $user
     * @return string
     */
    public static function getUserMemberExpirationDate(Authenticatable|User $user): string
    {
        return Carbon::parse($user->member->expiration_date)->toDateString();
    }

}
