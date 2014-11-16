{commentsnippet mode="start" name="medien.cms.tpl"}
{foreach $workItems as $item}

    <div class="objectContainer" >

        <div class="objectFloat left" style="width:80px;" >
            <img src="http://www.fsw.uzh.ch/static/img/{$item->getIcon()}" />
        </div><br />
        <b>{$item->getBeteiligter()}</b>,&nbsp;
        {$item->getSendetitel()} vom  {$item->getDatum()|date_format:"%d.%m.%Y"}
        <br />
        <a href="{$item->getLink()}" class="www" target="_blank">
            {$item->getGespraechstitel()}

        </a>
        <br style="margin-bottom: 0px" class="floatclear" />

    </div>



{/foreach}

{commentsnippet mode="stop" name="medien.cms.tpl"}
