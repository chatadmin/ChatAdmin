<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class FriendCircleTimeline
 *
 * @since 2.0
 *
 * @Entity(table="friend_circle_timeline")
 */
class FriendCircleTimeline extends Model
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
     * 发圈人uid
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 朋友uid
     *
     * @Column(name="friend_uid", prop="friendUid")
     *
     * @var int
     */
    private $friendUid;

    /**
     * 朋友圈id
     *
     * @Column()
     *
     * @var int
     */
    private $fcmid;

    /**
     * 是否是自己的朋友圈（1 是 0不是）
     *
     * @Column(name="is_own", prop="isOwn")
     *
     * @var int
     */
    private $isOwn;

    /**
     * 是否屏蔽（1 正常  0屏蔽）
     *
     * @Column(name="shield_circle", prop="shieldCircle")
     *
     * @var int
     */
    private $shieldCircle;

    /**
     * 创建时间
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
     * @param int $uid
     *
     * @return void
     */
    public function setUid(int $uid): void
    {
        $this->uid = $uid;
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
     * @param int $fcmid
     *
     * @return void
     */
    public function setFcmid(int $fcmid): void
    {
        $this->fcmid = $fcmid;
    }

    /**
     * @param int $isOwn
     *
     * @return void
     */
    public function setIsOwn(int $isOwn): void
    {
        $this->isOwn = $isOwn;
    }

    /**
     * @param int $shieldCircle
     *
     * @return void
     */
    public function setShieldCircle(int $shieldCircle): void
    {
        $this->shieldCircle = $shieldCircle;
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
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function getFriendUid(): ?int
    {
        return $this->friendUid;
    }

    /**
     * @return int
     */
    public function getFcmid(): ?int
    {
        return $this->fcmid;
    }

    /**
     * @return int
     */
    public function getIsOwn(): ?int
    {
        return $this->isOwn;
    }

    /**
     * @return int
     */
    public function getShieldCircle(): ?int
    {
        return $this->shieldCircle;
    }

    /**
     * @return int
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

}
