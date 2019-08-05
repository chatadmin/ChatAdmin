<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class UserFriend
 *
 * @since 2.0
 *
 * @Entity(table="user_friend")
 */
class UserFriend extends Model
{
    /**
     * 主键
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 自己的id
     *
     * @Column(name="self_uid", prop="selfUid")
     *
     * @var int
     */
    private $selfUid;

    /**
     * 朋友的id
     *
     * @Column(name="friend_uid", prop="friendUid")
     *
     * @var int
     */
    private $friendUid;

    /**
     * 备注昵称
     *
     * @Column(name="remarks_name", prop="remarksName")
     *
     * @var string
     */
    private $remarksName;

    /**
     * 朋友的电话
     *
     * @Column(name="friend_phone", prop="friendPhone")
     *
     * @var string|null
     */
    private $friendPhone;

    /**
     * 聊天背景图片
     *
     * @Column(name="chat_url", prop="chatUrl")
     *
     * @var string|null
     */
    private $chatUrl;

    /**
     * 添加好友来源（1 扫一扫  2 通过群聊）
     *
     * @Column()
     *
     * @var int|null
     */
    private $source;

    /**
     * 1 添加人  2 被添加人
     *
     * @Column(name="add_to", prop="addTo")
     *
     * @var int
     */
    private $addTo;

    /**
     * 首字母
     *
     * @Column()
     *
     * @var string|null
     */
    private $initials;

    /**
     * 状态（3 拉黑好友 2 陌生人 1 好友 ）
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 添加时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
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
     * @param int $selfUid
     *
     * @return void
     */
    public function setSelfUid(int $selfUid): void
    {
        $this->selfUid = $selfUid;
    }

    /**
     * @param int $friendUid
     *
     * @return void
     */
    public function setFriendUid(int $friendUid): void
    {
        $this->friendUid = $friendUid;
    }

    /**
     * @param string $remarksName
     *
     * @return void
     */
    public function setRemarksName(string $remarksName): void
    {
        $this->remarksName = $remarksName;
    }

    /**
     * @param string|null $friendPhone
     *
     * @return void
     */
    public function setFriendPhone(?string $friendPhone): void
    {
        $this->friendPhone = $friendPhone;
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
     * @param int|null $source
     *
     * @return void
     */
    public function setSource(?int $source): void
    {
        $this->source = $source;
    }

    /**
     * @param int $addTo
     *
     * @return void
     */
    public function setAddTo(int $addTo): void
    {
        $this->addTo = $addTo;
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
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSelfUid(): ?int
    {
        return $this->selfUid;
    }

    /**
     * @return int
     */
    public function getFriendUid(): ?int
    {
        return $this->friendUid;
    }

    /**
     * @return string
     */
    public function getRemarksName(): ?string
    {
        return $this->remarksName;
    }

    /**
     * @return string|null
     */
    public function getFriendPhone(): ?string
    {
        return $this->friendPhone;
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
    public function getSource(): ?int
    {
        return $this->source;
    }

    /**
     * @return int
     */
    public function getAddTo(): ?int
    {
        return $this->addTo;
    }

    /**
     * @return string|null
     */
    public function getInitials(): ?string
    {
        return $this->initials;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

}
