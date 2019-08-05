<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class SingleRedEnvelopes
 *
 * @since 2.0
 *
 * @Entity(table="single_red_envelopes")
 */
class SingleRedEnvelopes extends Model
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
     * 红包主题
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
     * 红包发送人id
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
     * @var int
     */
    private $acceptUid;

    /**
     * 1未领取,2已经领取,3已退还
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 红包发送时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int|null
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
     * @param int $uid
     *
     * @return void
     */
    public function setUid(int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @param int $acceptUid
     *
     * @return void
     */
    public function setAcceptUid(int $acceptUid): void
    {
        $this->acceptUid = $acceptUid;
    }

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status): void
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
     * @param string $uniqueValue
     *
     * @return void
     */
    public function setUniqueValue(string $uniqueValue): void
    {
        $this->uniqueValue = $uniqueValue;
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
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function getAcceptUid(): ?int
    {
        return $this->acceptUid;
    }

    /**
     * @return int
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

    /**
     * @return string
     */
    public function getUniqueValue(): ?string
    {
        return $this->uniqueValue;
    }

}
