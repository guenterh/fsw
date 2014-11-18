
{commentsnippet mode="start" name="lehrveranstaltung.archiv.tpl"}



<!--{$labels}-->

<div class="tabs"> <!-- begin: <div class="tabs" -->
    
    <ul>

        {foreach $tabheaders as $tabheaderarray}
            
            <li><a href="#tab-{$tabheaderarray@key}">{$labels[$tabheaderarray@key]}</a></li>
        {/foreach}
    </ul>

    {foreach $tabbodies as $tabbodyarray}
        <div id="tab-{$tabbodyarray@key}" class="tab">
            <ul class="type1">
            {foreach $tabbodyarray as $tabbody}
               <li class="marginTop ">
                 <p class="noMarginBottom">

                 <strong> {$tabbody->getLeitung()}</strong>,&nbsp;

                    {$tabbody->getTag()},&nbsp;
                    {$tabbody->getVonZeit()}&nbsp; -&nbsp;
                    {$tabbody->getBisZeit()} <br/>

                     {if $tabbody->getVvzlink() != null}
                          <a class="internal"   href="{$tabbody->getVvzlink()}" target="_blank"><strong>{$tabbody->getTitel()}</strong></a>
                      {else}
                          <strong>{$tabbody->getTitel()}</strong>
                      {/if}




                  </p>
                    {if $tabbody->getText() != null && $tabbody->getVvzlink() == null}
                        <div>
                            <a class="internal abstractCaption" href="#">mehr</a>
                            
                            <div class="abstractText">
                               {$tabbody->getText()} &nbsp;
                            </div>
                        </div>
                    {/if}

               </li>


            {/foreach}
                </ul>
        </div>
    {/foreach}




</div>

{commentsnippet mode="stop" name="lehrveranstaltung.archiv.tpl"}