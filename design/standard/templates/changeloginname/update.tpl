<div class="border-box">
<div class="border-tl"><div class="border-tr"><div class="border-tc"></div></div></div>
<div class="border-ml"><div class="border-mr"><div class="border-mc float-break">

    <h1>{"Cambia il nome di login per l'oggetto"|i18n('changeloginname/update')} <a href={$node.url_alias|ezurl()}>{$current_node.name|wash()}</a> </h1>

    {if $message}
        <h2>{$message}</h2>
    {/if}

    {if $show_form}
    <form action={concat('changeloginname/update/',$current_node.node_id)|ezurl()} method="POST">
        <table class="list">
            <tr class="bglight">
                <td>{'Login Name'|i18n('changeloginname/update')}</td>
                <td><input type="text" name="new_login_name" value="{$login_name}" size="70"/></td>
            </tr>

        </table>
        <input class="button" type="submit" name="ChangeLoginName" value="{'Update'|i18n('changeloginname/update')}"/>
    </form>
    {/if}


</div></div></div>
<div class="border-bl"><div class="border-br"><div class="border-bc"></div></div></div>
</div>

