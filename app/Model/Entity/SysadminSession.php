<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 管理员登录信息
 * Class SysadminSession
 *
 * @since 2.0
 *
 * @Entity(table="sysadmin_session")
 */
class SysadminSession extends Model
{
    /**
     * 
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 账号
     *
     * @Column()
     *
     * @var string
     */
    private $username;

    /**
     * 登录标识
     *
     * @Column(name="session_key", prop="sessionKey")
     *
     * @var string|null
     */
    private $sessionKey;

    /**
     * 最近登录时间
     *
     * @Column(name="login_time", prop="loginTime")
     *
     * @var int
     */
    private $loginTime;

    /**
     * 最后访问时间
     *
     * @Column(name="access_time", prop="accessTime")
     *
     * @var int
     */
    private $accessTime;

    /**
     * 是否在线，判断是否在线除判断这个值外，还应该判断最后访问时间
     *
     * @Column(name="is_online", prop="isOnline")
     *
     * @var int
     */
    private $isOnline;

    /**
     * 
     *
     * @Column(name="login_ip", prop="loginIp")
     *
     * @var string
     */
    private $loginIp;

    /**
     * 状态
     *
     * @Column()
     *
     * @var int
     */
    private $state;


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
     * @param int $uid
     *
     * @return void
     */
    public function setUid(int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @param string $username
     *
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string|null $sessionKey
     *
     * @return void
     */
    public function setSessionKey(?string $sessionKey): void
    {
        $this->sessionKey = $sessionKey;
    }

    /**
     * @param int $loginTime
     *
     * @return void
     */
    public function setLoginTime(int $loginTime): void
    {
        $this->loginTime = $loginTime;
    }

    /**
     * @param int $accessTime
     *
     * @return void
     */
    public function setAccessTime(int $accessTime): void
    {
        $this->accessTime = $accessTime;
    }

    /**
     * @param int $isOnline
     *
     * @return void
     */
    public function setIsOnline(int $isOnline): void
    {
        $this->isOnline = $isOnline;
    }

    /**
     * @param string $loginIp
     *
     * @return void
     */
    public function setLoginIp(string $loginIp): void
    {
        $this->loginIp = $loginIp;
    }

    /**
     * @param int $state
     *
     * @return void
     */
    public function setState(int $state): void
    {
        $this->state = $state;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    public function getSessionKey(): ?string
    {
        return $this->sessionKey;
    }

    /**
     * @return int
     */
    public function getLoginTime(): ?int
    {
        return $this->loginTime;
    }

    /**
     * @return int
     */
    public function getAccessTime(): ?int
    {
        return $this->accessTime;
    }

    /**
     * @return int
     */
    public function getIsOnline(): ?int
    {
        return $this->isOnline;
    }

    /**
     * @return string
     */
    public function getLoginIp(): ?string
    {
        return $this->loginIp;
    }

    /**
     * @return int
     */
    public function getState(): ?int
    {
        return $this->state;
    }

}
