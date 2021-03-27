<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    //반환되는 내용 수정.
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            // .는 문자열 플러스, this는 Todo Class
            'title' => "타이틀 : " . $this->title,
            'content' => "컨텐트 : " . $this->content,
            'create_at' => $this->created_at->diffForHumans() . " 잔에 작성되었다."
        ];
    }
}
