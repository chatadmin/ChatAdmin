<?php declare(strict_types=1);

namespace App\Validator;

use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Contract\ValidatorInterface;
/**
 * Class LoginValidator
 *
 * @since 2.0
 *
 * @Validator(name="DataDealwithValidator")
 */
class DataDealwithValidator implements ValidatorInterface
{
    /**
     * @param array $data
     * @param array $params
     * @return array
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public function validate(array $data, array $params): array
    {

        $page =(int) ( $data['data']['page'] ?? $data['page'] );
        $limit = (int) ($data['data']['limit'] ?? $data['limit']);
        if($page < 1)
            $page = 1;
        if($limit > 90){
            $limit = 90;
        }
        $where = $data['data'] ?? [];
        $data['data']['page'] = $page;
        $data['data']['limit'] = $limit;

        return ['data'=>$data['data'],'limit'=>$limit,'page'=>$page,'where'=>$where];
    }
}
