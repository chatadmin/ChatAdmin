<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class UserGroupRelation
 *
 * @since 2.0
 *
 * @Entity(table="user_group_relation")
 */
class UserGroupRelation extends Model
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
     * 用户uid
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 群组id
     *
     * @Column(name="group_id", prop="groupId")
     *
     * @var int
     */
    private $groupId;

    /**
     * 用户在群组昵称
     *
     * @Column(name="user_name", prop="userName")
     *
     * @var string|null
     */
    private $userName;

    /**
     * 角色（1 群主 2管理员 3普通人员）
     *
     * @Column()
     *
     * @var int
     */
    private $role;

    /**
     * 聊天状态(1 正常 2 拉黑)
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 聊天背景
     *
     * @Column(name="chat_url", prop="chatUrl")
     *
     * @var string|null
     */
    private $chatUrl;

    /**
     * 修改时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int|null
     */
    private $updateTime;

    /**
     * 加入群时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 最后一次拉去该组消息的消息id
     *
     * @Column(name="last_ack_msg_id", prop="lastAckMsgId")
     *
     * @var string|null
     */
    private $lastAckMsgId;


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
     * @param int $groupId
     *
     * @return void
     */
    public function setGroupId(int $groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * @param string|null $userName
     *
     * @return void
     */
    public function setUserName(?string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @param int $role
     *
     * @return void
     */
    public function setRole(int $role): void
    {
        $this->role = $role;
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
     * @param string|null $chatUrl
     *
     * @return void
     */
    public function setChatUrl(?string $chatUrl): void
    {
        $this->chatUrl = $chatUrl;
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
     * @param string|null $lastAckMsgId
     *
     * @return void
     */
    public function setLastAckMsgId(?string $lastAckMsgId): void
    {
        $this->lastAckMsgId = $lastAckMsgId;
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
     * @return int
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @return int
     */
    public function getRole(): ?int
    {
        return $this->role;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getChatUrl(): ?string
    {
        return $this->chatUrl;
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
    public function getLastAckMsgId(): ?string
    {
        return $this->lastAckMsgId;
    }

}
