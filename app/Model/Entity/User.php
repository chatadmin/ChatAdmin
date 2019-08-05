<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 *
 * Class User
 *
 * @since 2.0
 *
 * @Entity(table="user")
 */
class User extends Model
{
    /**
     *
     * @Id()
     * @Column(name="id")
     *
     * @var int
     */
    private $id;

    /**
     * 微信号
     *
     * @Column(name="username")
     *
     * @var string|null
     */
    private $username;

    /**
     * 电话号码
     *
     * @Column(name="phone")
     *
     * @var string
     */
    private $phone;

    /**
     * 昵称
     *
     * @Column(name="nickname")
     *
     * @var string
     */
    private $nickname;

    /**
     * 密码
     *
     * @Column(name="password",hidden=true)
     *
     * @var string
     */
    private $password;

    /**
     * 头像
     *
     * @Column(name="head_portrait", prop="headPortrait")
     *
     * @var string|null
     */
    private $headPortrait;

    /**
     * 生日
     *
     * @Column(name="birthday")
     *
     * @var int|null
     */
    private $birthday;

    /**
     * 性别(1.男 2.女)
     *
     * @Column(name="sex")
     *
     * @var int|null
     */
    private $sex;

    /**
     * 地区
     *
     * @Column()
     *
     * @var string|null
     */
    private $region;

    /**
     * 个性签名
     *
     * @Column()
     *
     * @var string|null
     */
    private $signature;

    /**
     * 修改时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int|null
     */
    private $updateTime;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * token
     *
     * @Column()
     *
     * @var string|null
     */
    private $token;

    /**
     * 盐
     *
     * @Column()
     *
     * @var string
     */
    private $salt;

    /**
     * 首字母
     *
     * @Column()
     *
     * @var string|null
     */
    private $initials;

    /**
     * 钱包
     *
     * @Column(name="wallet")
     *
     * @var float|null
     */
    private $wallet;

    /**
     * 提款密码
     *
     * @Column(name="withdrawal_password", prop="withdrawalPassword")
     *
     * @var string|null
     */
    private $withdrawalPassword;

    /**
     * 1 正常  2 禁用
     *
     * @Column(name="is_normal", prop="isNormal")
     *
     * @var int
     */
    private $isNormal;


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
     * @param string|null $username
     *
     * @return void
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $phone
     *
     * @return void
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param string $nickname
     *
     * @return void
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string|null $headPortrait
     *
     * @return void
     */
    public function setHeadPortrait(?string $headPortrait): void
    {
        $this->headPortrait = $headPortrait;
    }

    /**
     * @param int|null $birthday
     *
     * @return void
     */
    public function setBirthday(?int $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @param int|null $sex
     *
     * @return void
     */
    public function setSex(?int $sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @param string|null $region
     *
     * @return void
     */
    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @param string|null $signature
     *
     * @return void
     */
    public function setSignature(?string $signature): void
    {
        $this->signature = $signature;
    }

    /**
     * @param int $isUse
     *
     * @return void
     */
    public function setIsUse(int $isUse): void
    {
        $this->isUse = $isUse;
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
     * @param int $createTime
     *
     * @return void
     */
    public function setCreateTime(int $createTime): void
    {
        $this->createTime = $createTime;
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
     * @param string $salt
     *
     * @return void
     */
    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * @param string|null $initials
     *
     * @return void
     */
    public function setInitials(?string $initials): void
    {
        $this->initials = $initials;
    }

    /**
     * @param float|null $wallet
     *
     * @return void
     */
    public function setWallet(?float $wallet): void
    {
        $this->wallet = $wallet;
    }

    /**
     * @param string|null $withdrawalPassword
     *
     * @return void
     */
    public function setWithdrawalPassword(?string $withdrawalPassword): void
    {
        $this->withdrawalPassword = $withdrawalPassword;
    }

    /**
     * @param int $isNormal
     *
     * @return void
     */
    public function setIsNormal(int $isNormal): void
    {
        $this->isNormal = $isNormal;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getHeadPortrait(): ?string
    {
        return $this->headPortrait;
    }

    /**
     * @return int|null
     */
    public function getBirthday(): ?int
    {
        return $this->birthday;
    }

    /**
     * @return int|null
     */
    public function getSex(): ?int
    {
        return $this->sex;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @return string|null
     */
    public function getSignature(): ?string
    {
        return $this->signature;
    }

    /**
     * @return int
     */
    public function getIsUse(): ?int
    {
        return $this->isUse;
    }

    /**
     * @return int|null
     */
    public function getUpdateTime(): ?int
    {
        return $this->updateTime;
    }

    /**
     * @return int
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @return string|null
     */
    public function getInitials(): ?string
    {
        return $this->initials;
    }

    /**
     * @return float|null
     */
    public function getWallet(): ?float
    {
        return $this->wallet;
    }

    /**
     * @return string|null
     */
    public function getWithdrawalPassword(): ?string
    {
        return $this->withdrawalPassword;
    }

    /**
     * @return int
     */
    public function getIsNormal(): ?int
    {
        return $this->isNormal;
    }

}
