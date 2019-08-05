<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 *
 * Class AdminSession
 *
 * @since 2.0
 *
 * @Entity(table="sysadmin_session")
 */
class AdminSession extends Model
{
    /*protected const UPDATED_AT = 'update_time';
    protected const CREATED_AT = 'create_time';*/

    /**
     * @Id(incrementing=true)
     * @Column(name="id", prop="id")
     * @var int|null
     */
    private $id;

    /**
     *
     *
     * @Column(name="uid",prop="uid")
     * @var int|null
     */
    private $uid;

    /**
     *
     *
     * @Column(name="username", prop="username")
     * @var string|null
     */
    private $username;

    /**
     * @Column(name="session_key",prop="session_key")
     * @var string|null
     */
    private $sessionKey;

    /**
     *
     *
     * @Column(name="login_time", prop="login_time")
     * @var int|null
     */
    private $loginTime;


    /**
     *
     *
     * @Column(name="access_time", prop="access_time")
     * @var int|null
     */
    private $accessTime;

    /**@Column(name="is_online" ,prop="is_online")
     * @var int|null
     */
    private $isOnline;

    /**@Column(name="login_ip",prop="login_ip")
     * @var string|null
     */
    private $loginIp;


    /**
     * @Column(name="state",prop="state")
     * @var int|null
     */
    private $state;
    /**
     * @param int|null $id
     *
     * @return void
     */

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int|null $uid
     *
     * @return void
     */
    public function setUid(?int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @param string|null $username
     *
     * @return void
     */
    public function setUsername(?string $username): void
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
     * @param int|null $loginTime
     *
     * @return void
     */
    public function setLoginTime(?int $loginTime): void
    {
        $this->loginTime = $loginTime;
    }

    /**
     * @param int|null $accessTime
     * @return void
     */
    public function setAccessTime(?int $accessTime):void
    {
        $this->accessTime = $accessTime;
    }

    /**
     * @param int|null $isOnline
     * @return void
     *
     */
    public function setIsOnline(?int $isOnline):void
    {
        $this->isOnline = $isOnline;
    }

    /**
     * @param string|null $loginIp
     * @return void
     */
    public function setLoginIp(?string $loginIp):void
    {
        $this->loginIp = $loginIp;
    }

    /**
     * @param int|null $state
     * @return void
     */
    public function setState(?int $state):void
    {
        $this->state = $state;
    }
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return string|null
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
     * @return int|null
     */
    public function getState(): ?int
    {
        return $this->state;
    }

    /**
     * @return int|null
     */
    public function getLoginTime(): ?int
    {
        return $this->loginTime;
    }

    /**
     * @return int|null
     */
    public function getAccessTime(): ?int
    {
        return $this->accessTime;
    }

    /**
     * @return int|null
     */
    public function getIsOnline():?int
    {
        return $this->isOnline;
    }

    /**
     * @return string|null
     */
    public function getLoginIp():?string
    {
        return $this->loginIp;
    }
}
