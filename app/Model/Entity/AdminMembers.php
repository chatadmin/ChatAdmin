<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 后台登陆用户表
 * Class AdminMembers
 *
 * @since 2.0
 *
 * @Entity(table="admin_members")
 */
class AdminMembers extends Model
{
    /**
     * 主键ID
     * @Id()
     * @Column(name="id")
     *
     * @var int
     */
    private $id;

    /**
     * 登陆用户名
     *
     * @Column(name="uname")
     *
     * @var string
     */
    private $uname;

    /**
     * 密码
     *
     * @Column(name="passwd")
     *
     * @var string
     */
    private $passwd;

    /**
     * 用户登陆token值
     *
     * @Column(name="token")
     *
     * @var string|null
     */
    private $token;

    /**
     * 首次登陆时间
     *
     * @Column(name="first_login_time", prop="firstLoginTime")
     *
     * @var int|null
     */
    private $firstLoginTime;

    /**
     * 上次登陆时间
     *
     * @Column(name="last_login_time", prop="lastLoginTime")
     *
     * @var int|null
     */
    private $lastLoginTime;

    /**
     * 登陆次数
     *
     * @Column(name="login_times", prop="loginTimes")
     *
     * @var int|null
     */
    private $loginTimes;

    /**
     * 用户添加时间
     *
     * @Column(name="add_time", prop="addTime")
     *
     * @var int
     */
    private $addTime;

    /**
     * 用户更新时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int|null
     */
    private $updateTime;

    /**
     * 是否可用 1 不可用
     *
     * @Column(name="status")
     *
     * @var int|null
     */
    private $status;


    /**
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $uname
     *
     * @return void
     */
    public function setUname(string $uname): void
    {
        $this->uname = $uname;
    }

    /**
     * @param string $passwd
     *
     * @return void
     */
    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }

    /**
     * @param string|null $token
     *
     * @return void
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @param int|null $firstLoginTime
     *
     * @return void
     */
    public function setFirstLoginTime(?int $firstLoginTime): void
    {
        $this->firstLoginTime = $firstLoginTime;
    }

    /**
     * @param int|null $lastLoginTime
     *
     * @return void
     */
    public function setLastLoginTime(?int $lastLoginTime): void
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    /**
     * @param int|null $loginTimes
     *
     * @return void
     */
    public function setLoginTimes(?int $loginTimes): void
    {
        $this->loginTimes = $loginTimes;
    }

    /**
     * @param int $addTime
     *
     * @return void
     */
    public function setAddTime(int $addTime): void
    {
        $this->addTime = $addTime;
    }

    /**
     * @param int|null $updateTime
     *
     * @return void
     */
    public function setUpdateTime(?int $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    /**
     * @param int|null $status
     *
     * @return void
     */
    public function setStatus(?int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUname(): ?string
    {
        return $this->uname;
    }

    /**
     * @return string
     */
    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return int|null
     */
    public function getFirstLoginTime(): ?int
    {
        return $this->firstLoginTime;
    }

    /**
     * @return int|null
     */
    public function getLastLoginTime(): ?int
    {
        return $this->lastLoginTime;
    }

    /**
     * @return int|null
     */
    public function getLoginTimes(): ?int
    {
        return $this->loginTimes;
    }

    /**
     * @return int
     */
    public function getAddTime(): ?int
    {
        return $this->addTime;
    }

    /**
     * @return int|null
     */
    public function getUpdateTime(): ?int
    {
        return $this->updateTime;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

}
