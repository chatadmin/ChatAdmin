<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class CreateRed
 *
 * @since 2.0
 *
 * @Entity(table="create_red")
 */
class CreateRed extends Model
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
     * 群聊红包id
     *
     * @Column(name="group_red_id", prop="groupRedId")
     *
     * @var int|null
     */
    private $groupRedId;

    /**
     * 单聊红包id
     *
     * @Column(name="single_red_id", prop="singleRedId")
     *
     * @var int|null
     */
    private $singleRedId;

    /**
     * 红包金额
     *
     * @Column(name="amount_red", prop="amountRed")
     *
     * @var float
     */
    private $amountRed;

    /**
     * 红包生成时间
     *
     * @Column(name="send_time", prop="sendTime")
     *
     * @var int
     */
    private $sendTime;

    /**
     * 抢红包人uid
     *
     * @Column(name="accept_uid", prop="acceptUid")
     *
     * @var int|null
     */
    private $acceptUid;

    /**
     * 抢红包时间
     *
     * @Column(name="accept_time", prop="acceptTime")
     *
     * @var int|null
     */
    private $acceptTime;

    /**
     * 是否被抢
     *
     * @Column(name="is_use", prop="isUse")
     *
     * @var int
     */
    private $isUse;


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
     * @param int|null $groupRedId
     *
     * @return void
     */
    public function setGroupRedId(?int $groupRedId): void
    {
        $this->groupRedId = $groupRedId;
    }

    /**
     * @param int|null $singleRedId
     *
     * @return void
     */
    public function setSingleRedId(?int $singleRedId): void
    {
        $this->singleRedId = $singleRedId;
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
     * @param int $sendTime
     *
     * @return void
     */
    public function setSendTime(int $sendTime): void
    {
        $this->sendTime = $sendTime;
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
     * @param int|null $acceptTime
     *
     * @return void
     */
    public function setAcceptTime(?int $acceptTime): void
    {
        $this->acceptTime = $acceptTime;
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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getGroupRedId(): ?int
    {
        return $this->groupRedId;
    }

    /**
     * @return int|null
     */
    public function getSingleRedId(): ?int
    {
        return $this->singleRedId;
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
    public function getSendTime(): ?int
    {
        return $this->sendTime;
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
    public function getAcceptTime(): ?int
    {
        return $this->acceptTime;
    }

    /**
     * @return int
     */
    public function getIsUse(): ?int
    {
        return $this->isUse;
    }

}
