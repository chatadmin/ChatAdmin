<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class OfflineSingleChat
 *
 * @since 2.0
 *
 * @Entity(table="offline_single_chat")
 */
class OfflineSingleChat extends Model
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
     * 发送消息id
     *
     * @Column(name="send_uid", prop="sendUid")
     *
     * @var int
     */
    private $sendUid;

    /**
     * 接收人id
     *
     * @Column(name="accept_uid", prop="acceptUid")
     *
     * @var int
     */
    private $acceptUid;

    /**
     * 消息唯一值
     *
     * @Column(name="unique_value", prop="uniqueValue")
     *
     * @var string
     */
    private $uniqueValue;

    /**
     * 消息内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;

    /**
     * 消息来源
     *
     * @Column()
     *
     * @var string
     */
    private $from;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 消息类型
     *
     * @Column()
     *
     * @var int
     */
    private $type;


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
     * @param int $sendUid
     *
     * @return void
     */
    public function setSendUid(int $sendUid): void
    {
        $this->sendUid = $sendUid;
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
     * @param string $uniqueValue
     *
     * @return void
     */
    public function setUniqueValue(string $uniqueValue): void
    {
        $this->uniqueValue = $uniqueValue;
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @param string $from
     *
     * @return void
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
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
     * @param int $type
     *
     * @return void
     */
    public function setType(int $type): void
    {
        $this->type = $type;
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
    public function getSendUid(): ?int
    {
        return $this->sendUid;
    }

    /**
     * @return int
     */
    public function getAcceptUid(): ?int
    {
        return $this->acceptUid;
    }

    /**
     * @return string
     */
    public function getUniqueValue(): ?string
    {
        return $this->uniqueValue;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * @return int
     */
    public function getType(): ?int
    {
        return $this->type;
    }

}
