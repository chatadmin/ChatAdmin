<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class FriendCircleLike
 *
 * @since 2.0
 *
 * @Entity(table="friend_circle_like")
 */
class FriendCircleLike extends Model
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
     * 朋友圈id
     *
     * @Column()
     *
     * @var int
     */
    private $fcmid;

    /**
     * 点赞
     *
     * @Column()
     *
     * @var int|null
     */
    private $uid;

    /**
     * 
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
     * @param int $fcmid
     *
     * @return void
     */
    public function setFcmid(int $fcmid): void
    {
        $this->fcmid = $fcmid;
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
    public function getFcmid(): ?int
    {
        return $this->fcmid;
    }

    /**
     * @return int|null
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

}
