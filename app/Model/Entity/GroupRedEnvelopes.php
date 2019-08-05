<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class GroupRedEnvelopes
 *
 * @since 2.0
 *
 * @Entity(table="group_red_envelopes")
 */
class GroupRedEnvelopes extends Model
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
     * 红包的主题
     *
     * @Column()
     *
     * @var string
     */
    private $topic;

    /**
     * 红包金额
     *
     * @Column(name="amount_red", prop="amountRed")
     *
     * @var float
     */
    private $amountRed;

    /**
     * 群组id
     *
     * @Column(name="group_id", prop="groupId")
     *
     * @var int
     */
    private $groupId;

    /**
     * 红包个数
     *
     * @Column()
     *
     * @var int
     */
    private $number;

    /**
     * 发送红包人
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 红包时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 红包唯一值
     *
     * @Column(name="unique_value", prop="uniqueValue")
     *
     * @var string
     */
    private $uniqueValue;

    /**
     * 红包状态：1未退还,2已退还
     *
     * @Column()
     *
     * @var int|null
     */
    private $status;

    /**
     * 退还个数
     *
     * @Column(name="back_number", prop="backNumber")
     *
     * @var int|null
     */
    private $backNumber;

    /**
     * 退还金额
     *
     * @Column(name="back_amount", prop="backAmount")
     *
     * @var float|null
     */
    private $backAmount;


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
     * @param string $topic
     *
     * @return void
     */
    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }

    /**
     * @param float $amountRed
     *
     * @return void
     */
    public function setAmountRed(float $amountRed): void
    {
        $this->amountRed = $amountRed;
    }

    /**
     * @param int $groupId
     *
     * @return void
     */
    public function setGroupId(int $groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @param int $number
     *
     * @return void
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
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
     * @param int $createTime
     *
     * @return void
     */
    public function setCreateTime(int $createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @param string $uniqueValue
     *
     * @return void
     */
    public function setUniqueValue(string $uniqueValue): void
    {
        $this->uniqueValue = $uniqueValue;
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
     * @param int|null $backNumber
     *
     * @return void
     */
    public function setBackNumber(?int $backNumber): void
    {
        $this->backNumber = $backNumber;
    }

    /**
     * @param float|null $backAmount
     *
     * @return void
     */
    public function setBackAmount(?float $backAmount): void
    {
        $this->backAmount = $backAmount;
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
    public function getTopic(): ?string
    {
        return $this->topic;
    }

    /**
     * @return float
     */
    public function getAmountRed(): ?float
    {
        return $this->amountRed;
    }

    /**
     * @return int
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @return int
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * @return string
     */
    public function getUniqueValue(): ?string
    {
        return $this->uniqueValue;
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
    public function getBackNumber(): ?int
    {
        return $this->backNumber;
    }

    /**
     * @return float|null
     */
    public function getBackAmount(): ?float
    {
        return $this->backAmount;
    }

}
