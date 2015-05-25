{*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.6                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2015                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*}
{* Step 1 of New Event Wizard, and Edit Event Info form. *}

<div class="crm-block crm-form-block crm-event-manage-eventinfo-form-block">

        <div class="crm-submit-buttons">
        {include file="CRM/common/formButtons.tpl" location="top"}
        </div>
  <table class="form-layout-compressed">
           
    <!--##TODO: Create a new class for the enable tracking checkbox-->
    <tr class="crm-event-manage-eventinfo-form-block-is_active">
      <td>&nbsp;</td>
      <td>{$form.enable_tracking.html} {$form.enable_tracking.label}</td>
    </tr>
    
  </table>
 
        <div class="crm-submit-buttons">
           {include file="CRM/common/formButtons.tpl" location="bottom"}
        </div>
    {include file="CRM/common/showHide.tpl" elemType="table-row"}

    {include file="CRM/Form/validate.tpl"}
</div>

{literal}
<script type="text/javascript">
  CRM.$(function($) {
    var $form = $('form.{/literal}{$form.formClass}{literal}');
    $('#template_id', $form).change(function() {
      $(this).closest('.crm-ajax-container, #crm-main-content-wrapper')
        .crmSnippet({url: CRM.url('civicrm/event/add', {action: 'add', reset: 1, template_id: $(this).val()})})
        .crmSnippet('refresh');
    })
  });
</script>
{/literal}

