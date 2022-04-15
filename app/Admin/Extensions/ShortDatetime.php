<?php

namespace App\Admin\Extensions;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Displayers\AbstractDisplayer;

class ShortDatetime extends AbstractDisplayer
{
    public function display($placement = 'right'): string
    {
        $dirCol = [
            'top'=>1,
            'right'=>2,
            'bottom'=>3,
            'left'=>4,
        ];
        $dir = $dirCol[$placement]??3;
        $limit = substr($this->value, 5);
        Admin::script("$('.tt-left').on('mouseover', function () {
       var title = $(this).data('title');
    var idx = layer.tips(title, this, {
      tips: [$dir, '#5d71b6'],
      time: 0,
      maxWidth: 210,
    });

    $(this).attr('layer-idx', idx);
}).on('mouseleave', function () {
    layer.close($(this).attr('layer-idx'));

    $(this).attr('layer-idx', '');
});");

        return <<<EOT
<a class="tt-left"  data-title="{$this->value}" >{$limit}</a>
EOT;
    }
}
