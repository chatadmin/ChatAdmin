<?php
namespace App\Http\Library;

class Image
{

    private $image;
    private $imageWidth;
    private $imageHeight;
    private $string;

    public function __construct($imageHeight=25,$imageWidth=70,$string='')
    {
        $this->imageHeight = $imageHeight;
        $this->imageWidth = $imageWidth;
        $this->string = $string;
    }

    /**
     * 生成画布
     */
    public function LImageCreate()
    {
        $this->image = imagecreate($this->imageWidth, $this->imageHeight);
    }

    /**
     * 填充背景颜色
     */
    public function LImagecolorallocate(){

        if(!$this->string){

            $ychar="0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
            $list=explode(",",$ychar);
            for($i=0;$i<4;$i++){

                $randnum=rand(0,35);
                $this->string.=$list[$randnum];

            }

        }

        imagecolorallocate($this->image, 255,255,255);
        $black = imagecolorallocate($this->image, 0,0,0);

        for ($i=1; $i<=100; $i++) {
            imagestring($this->image,1,mt_rand(1,$this->imageWidth),mt_rand(1,$this->imageHeight),
                "@",imagecolorallocate($this->image,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)));
        }

        //为了区别于背景，这里的颜色不超过200，上面的不小于200
        for ($i=0;$i<strlen($this->string);$i++){
            imagestring($this->image, mt_rand(3,5),(int)($i*$this->imageWidth/4+mt_rand(2,7)),
                mt_rand(1,(int)ceil($this->imageHeight/2-2)), $this->string[$i],imagecolorallocate($this->image,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200)));
        }
        imagerectangle($this->image,0,0,$this->imageWidth-1,$this->imageHeight-1,$black);//画一个矩形

    }

    public function LImagePNG(){

        return ['imgdata'=>ImagePNG($this->image),'code'=>$this->string];
    }

    /*销毁图片*/
    public function LImageDestroy()
    {
        imagedestroy($this->image);
    }
}