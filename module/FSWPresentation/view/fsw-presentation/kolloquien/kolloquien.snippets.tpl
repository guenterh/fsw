

{commentsnippet mode="start" name="kolloquien.snippets.tpl"}
  {foreach $workItems as $item}

    <div class="objectContainer" >


        <h2>{$item->getTitelKolloquium()}</h2>



        <div >
            <a class="internal abstractCaption" href="#">mehr</a>
            <p> &nbsp;</p>
            <div class="abstractText veranstaltungen">
                {foreach $item->getVeranstaltung() as $veranstaltung}

                    {foreach $veranstaltung->getVortragend() as $vortragend}


                        {if $vortragend->getPersonenlink() != null}
                            <span><a class="internal" target="_blank" href="{$vortragend->getPersonenlink()}">{$vortragend->getName()->getVorName()}&nbsp;{$vortragend->getName()->getNachName()}</a></span>
                        {else}
                            <span>{$vortragend->getName()->getVorName()}&nbsp;{$vortragend->getName()->getNachName()}</span>
                        {/if}

                    {/foreach}

                    {foreach $veranstaltung->getVortragend() as $vortragend}

                        {if $vortragend@first}
                            {if $vortragend->getInstitution()->getInstitutionlink() != null}
                                <span><a class="internal" target="_blank" href="{$vortragend->getInstitution()->getInstitutionlink()}">{$vortragend->getInstitution()->getName()}</a></span>
                            {else}
                                <span>{$vortragend->getInstitution()->getName()}</span>
                            {/if}
                            <!--
                            {if $vortragend->getInstitution()->getInstitutionBildPfad() != null}
                                <p><img src="{$vortragend->getInstitution()->getInstitutionBildPfad()}" alt="ein Bild der Institution"/></p>
                            {/if}
                            -->
                        {/if}

                    {/foreach}

                    <p><strong>{$veranstaltung->getTopic()->getTitel()}&nbsp;&nbsp;({$veranstaltung->getVeranstaltungsdatum()|date_format:"%d.%m.%Y"})</strong></p>

                        {foreach $veranstaltung->getVortragend() as $vortragend}

                            {if $vortragend->getPersoneninformation() != null && strlen($vortragend->getPersoneninformation()) > 0}


                                <div class="vortragende">
                                    <a class="internal abstractCaptionChild" href="#">mehr zu Personen</a>
                                    <div class="abstractTextChild">
                                        {$vortragend->getPersoneninformation()}
                                    </div>
                                </div>
                            {/if}

                        {/foreach}

                    {if $veranstaltung->getBemerkung() != null}
                        <p>{$veranstaltung->getBemerkung()}</p>
                    {/if}

                    <br/>
                {/foreach}
            </div>
        </div>




    </div>


  {/foreach}

{commentsnippet mode="stop" name="kolloquien.snippets.tpl"}
