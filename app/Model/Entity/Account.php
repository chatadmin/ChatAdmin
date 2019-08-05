<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class Account
 *
 * @since 2.0
 *
 * @Entity(table="account")
 */
class Account extends Model
{
    /**
     * 主键id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 账变金额
     *
     * @Column(name="amount_count", prop="amountCount")
     *
     * @var float
     */
    private $amountCount;

    /**
     * 用户id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 接收人id
     *
     * @Column(name="accept_uid", prop="acceptUid")
     *
     * @var int|null
     */
    private $acceptUid;

    /**
     * 组id
     *
     * @Column(name="group_id", prop="groupId")
     *
     * @var int|null
     */
    private $groupId;

    /**
     * 1.个人红包领取，2发个人红包，3群组领取红包，4群组发红红包，5群组退还红包，6个人退还红包
     *
     * @Column()
     *
     * @var int|null
     */
    private $status;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int|null
     */
    private $createTime;


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
     * @param float $amountCount
     *
     * @return void
     */
    public function setAmountCount(float $amountCount): void
    {
        $this->amountCount = $amountCount;
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
     * @param int|null $acceptUid
     *
     * @return void
     */
    public function setAcceptUid(?int $acceptUid): void
    {
        $this->acceptUid = $acceptUid;
    }

    /**
     * @param int|null $groupId
     *
     * @return void
     */
    public function setGroupId(?int $groupId): void
    {
        $this->groupId = $groupId;
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
     * @param int|null $createTime
     *
     * @return void
     */
    public function setCreateTime(?int $createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmountCount(): ?float
    {
        return $this->amountCount;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return int|null
     */
    public function getAcceptUid(): ?int
    {
        return $this->acceptUid;
    }

    /**
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return int|null
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

}
