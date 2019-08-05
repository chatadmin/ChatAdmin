<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class FriendCircleComment
 *
 * @since 2.0
 *
 * @Entity(table="friend_circle_comment")
 */
class FriendCircleComment extends Model
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
     * 评论人id
     *
     * @Column(name="com_uid", prop="comUid")
     *
     * @var int
     */
    private $comUid;

    /**
     * 评论内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;

    /**
     * 评论时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 朋友圈id
     *
     * @Column()
     *
     * @var int
     */
    private $fcmid;


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
     * @param int $comUid
     *
     * @return void
     */
    public function setComUid(int $comUid): void
    {
        $this->comUid = $comUid;
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
     * @param int $createTime
     *
     * @return void
     */
    public function setCreateTime(int $createTime): void
    {
        $this->createTime = $createTime;
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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getComUid(): ?int
    {
        return $this->comUid;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
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
    public function getFcmid(): ?int
    {
        return $this->fcmid;
    }

}
