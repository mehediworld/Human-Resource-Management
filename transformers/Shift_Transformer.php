<?php

namespace HRM\Transformers;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use HRM\Core\Common\Traits\Transformer_Manager;
use HRM\Core\Common\Resource_Editors;
use League\Fractal\Resource\Item;
use HRM\Models\Shift;
use HRM\Transformers\Department_Transformer;

class Shift_Transformer extends TransformerAbstract {

    use Resource_Editors;

    protected $defaultIncludes = [
        //'department'
    ];

    public function transform( Shift $item ) {
        
        return [
            'id'            => $item->id,
            'name'          => $item->name,
            'status'        => $item->status,
            'puch_start'    => $item->puch_start,
            'times'         => maybe_unserialize( $item->times ),
            'created_at'    => $item->created_at,
            'updated_at'    => $item->updated_at
        ];
    }

    public function includeDepartment( Shift $item ) {
        $department = $item->department()->first();

        if ( $department ) {
            return $this->item( $department, new Department_Transformer );
        }

        return null;
    }


}