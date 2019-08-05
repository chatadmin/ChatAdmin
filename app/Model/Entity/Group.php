<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class Group
 *
 * @since 2.0
 *
 * @Entity(table="group")
 */
class Group extends Model
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
     * 群主uid
     *
     * @Column(name="owner_uid", prop="ownerUid")
     *
     * @var int
     */
    private $ownerUid;

    /**
     * 群名称
     *
     * @Column(name="group_name", prop="groupName")
     *
     * @var string|null
     */
    private $groupName;

    /**
     * 群公告
     *
     * @Column()
     *
     * @var string|null
     */
    private $describe;

    /**
     * 修改时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int|null
     */
    private $updateTime;

    /**
     * 创建群时间
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
     * @param int $ownerUid
     *
     * @return void
     */
    public function setOwnerUid(int $ownerUid): void
    {
        $this->ownerUid = $ownerUid;
    }

    /**
     * @param string|null $groupName
     *
     * @return void
     */
    public function setGroupName(?string $groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @param string|null $describe
     *
     * @return void
     */
    public function setDescribe(?string $describe): void
    {
        $this->describe = $describe;
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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOwnerUid(): ?int
    {
        return $this->ownerUid;
    }

    /**
     * @return string|null
     */
    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    /**
     * @return string|null
     */
    public function getDescribe(): ?string
    {
        return $this->describe;
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

}
