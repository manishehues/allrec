function arm_hide_show_subscription_plan_notice(){var e="arm_pp_lock_key";arm_hide_gutenberg_notice("blank_plan_amount"),arm_hide_gutenberg_notice("invalid_plan_amount");var t=jQuery(".paid_subscription_options_recurring_payment_cycle_label"),n=jQuery(".paid_subscription_options_recurring_payment_cycle_amount"),r=!1,a=!1,o=!1;t.each(function(){""==jQuery(this).val()&&(r=!0)}),n.each(function(){""!=jQuery(this).val()?ArmPlanNumberValidation(this)||(o=!0):a=!0}),r?(arm_lock_postSaving(e),arm_display_gutenber_notice("arm_label_blank")):arm_hide_gutenberg_notice("arm_label_blank"),a?(arm_lock_postSaving(e),arm_display_gutenber_notice("blank_plan_amount")):arm_hide_gutenberg_notice("blank_plan_amount"),o&&(arm_lock_postSaving(e),arm_display_gutenber_notice("invalid_plan_amount")),r||a||o||arm_unlock_postSaving(e)}function ArmPlanNumberValidation(e){e=jQuery(e).val();return!!/^[0-9.]*$/.test(e)}function arm_unlock_postSaving(e){wp.data.select("core/editor").isPostSavingLocked()&&(wp.data.dispatch("core/editor").unlockPostSaving(e),void 0!==wp.data.dispatch("core/editor").unlockPostAutosaving&&wp.data.dispatch("core/editor").unlockPostAutosaving(e))}function arm_lock_postSaving(e){wp.data.dispatch("core/editor").lockPostSaving(e),void 0!==wp.data.dispatch("core/editor").lockPostAutosaving&&wp.data.dispatch("core/editor").lockPostAutosaving(e)}function arm_display_gutenber_notice(e){"blank_plan_amount"==e?wp.data.dispatch("core/notices").createNotice("error",ARMEDITORNOTICELABEL+AMOUNTERROR,{id:"arm_blank_amount_notice"}):"invalid_plan_amount"==e?wp.data.dispatch("core/notices").createNotice("error",ARMEDITORNOTICELABEL+INVALIDAMOUNTERROR,{id:"arm_invalid_amount_notice"}):"arm_label_blank"==e&&wp.data.dispatch("core/notices").createNotice("error",ARMEDITORNOTICELABEL+LABELERROR,{id:"arm_blank_label_notice"})}function arm_hide_gutenberg_notice(e){"blank_plan_amount"==e?wp.data.dispatch("core/notices").removeNotice("arm_blank_amount_notice"):"invalid_plan_amount"==e?wp.data.dispatch("core/notices").removeNotice("arm_invalid_amount_notice"):"arm_label_blank"==e&&wp.data.dispatch("core/notices").removeNotice("arm_blank_label_notice")}function isNumber(e){e=e.which||e.keyCode;return!(46!=e&&31<e&&(e<48||57<e))}function ArmNumberValidation(e,t){e=e.which||e.keyCode,t=jQuery(t).val();return!(46!=e&&31<e&&(e<48||57<e)&&37!=e&&39!=e)&&!(""!=t&&1<t.split(".").length&&46==e)}!function(){var r=wp.element.createElement,a={};registerBlockType=wp.blocks.registerBlockType,RichText=wp.blocks.RichText,source=wp.blocks.source;var e=wp.i18n.__,t=r("svg",{width:20,height:20,viewBox:"-3 -1 23 20.22",style:{fill:"#005aee"}},r("path",{d:"M4.407,20.231 C2.002,14.225 3.926,9.833 3.926,9.833 C8.781,0.839 22.999,10.111 22.999,10.111 C5.011,3.480 4.407,20.231 4.407,20.231 ZM3.520,6.918 C1.576,6.918 -0.000,5.368 -0.000,3.455 C-0.000,1.543 1.576,-0.007 3.520,-0.007 C5.464,-0.007 7.039,1.543 7.039,3.455 C7.039,5.368 5.464,6.918 3.520,6.918 Z"}));registerBlockType("armember/armember-shortcode",{title:e("Membership Shortcodes"),icon:t,category:"armember",keywords:[e("Membership"),e("ARMember"),e("Shortcode")],attributes:{ArmShortcode:{type:"string",default:""},content:{source:"html",selector:"h2"}},html:!0,insert:function(e){arm_open_form_shortcode_popup()},edit:function(t){window.arm_props_selected="1",window.arm_props=t;var e=jQuery("#block-"+window.arm_props.clientId).find(".wp-block-armember-armember-shortcode").val(),n=jQuery("#block-"+window.arm_props.clientId).find(".wp-block-armember-armember-shortcode").length;if("armember/armember-shortcode"==t.name){if(""==e||null==e||"undefined"==e||0==n){if(!t.isSelected)return r("textarea",{className:"wp-block-armember-armember-shortcode",style:a,onChange:function(e){t.setAttributes({ArmShortcode:jQuery("#block-"+window.arm_props.clientId).find(".wp-block-armember-armember-shortcode").val()})}},t.attributes.ArmShortcode);arm_open_form_shortcode_popup()}return r("textarea",{className:"wp-block-armember-armember-shortcode",style:a,onChange:function(e){t.setAttributes({ArmShortcode:jQuery("#block-"+window.arm_props.clientId).find(".wp-block-armember-armember-shortcode").val()})}},t.attributes.ArmShortcode)}},save:function(e){return void 0!==window.arm_props&&null!==window.arm_props&&1==jQuery("#block-"+window.arm_props.clientId).find(".editor-block-list__block-html-textarea").is(":visible")&&(e.attributes.ArmShortcode=jQuery("#block-"+window.arm_props.clientId).find(".editor-block-list__block-html-textarea").val()),e.attributes.ArmShortcode}}),registerBlockType("armember/armember-restrict-content",{title:e("Restrict Content Shortcode"),icon:t,category:"armember",keywords:[e("Membership"),e("ARMember"),e("Restriction")],attributes:{ArmRestrictContent:{type:"string",default:""},content:{source:"html",selector:"h2"}},html:!0,insert:function(e){arm_open_restriction_shortcode_popup()},edit:function(t){window.arm_props_selected="2",window.arm_restrict_content_props=t;var e=jQuery("#block-"+window.arm_restrict_content_props.clientId).find(".wp-block-armember-armember-restrict-content-textarea").val(),n=jQuery("#block-"+window.arm_restrict_content_props.clientId).find(".wp-block-armember-armember-restrict-content-textarea").length;if("armember/armember-restrict-content"==t.name){if(""==e||null==e||"undefined"==e||0==n){if(!t.isSelected)return r("textarea",{className:"wp-block-armember-armember-restrict-content-textarea",style:a,onChange:function(e){t.setAttributes({ArmRestrictContent:jQuery("#block-"+window.arm_restrict_content_props.clientId).find(".wp-block-armember-armember-restrict-content-textarea").val()})}},t.attributes.ArmRestrictContent);arm_open_restriction_shortcode_popup()}return r("textarea",{className:"wp-block-armember-armember-restrict-content-textarea",style:a,onChange:function(e){t.setAttributes({ArmRestrictContent:jQuery("#block-"+window.arm_restrict_content_props.clientId).find(".wp-block-armember-armember-restrict-content-textarea").val()})}},t.attributes.ArmRestrictContent)}},save:function(e){return void 0!==window.arm_restrict_content_props&&null!==window.arm_restrict_content_props&&1==jQuery("#block-"+window.arm_restrict_content_props.clientId).find(".editor-block-list__block-html-textarea").is(":visible")&&(e.attributes.ArmRestrictContent=jQuery("#block-"+window.arm_restrict_content_props.clientId).find(".editor-block-list__block-html-textarea").val()),e.attributes.ArmRestrictContent}})}((window.wp.blocks,window.wp.components,window.wp.i18n,window.wp.element,window.wp.editor)),jQuery(document).on("change","#arm_enable_paid_post",function(){var e,t,n,r,a="arm_pp_lock_key";jQuery(this).is(":checked")?"buy_now"==jQuery('input[name="paid_post_type"]:checked').val()?(""==jQuery('input[name="arm_paid_post_plan"]').val()?arm_lock_postSaving:arm_unlock_postSaving)(a):(e=jQuery(".paid_subscription_options_recurring_payment_cycle_label"),t=jQuery(".paid_subscription_options_recurring_payment_cycle_amount"),r=n=!1,e.each(function(){""==jQuery(this).val()&&(n=!0)}),t.each(function(){""==jQuery(this).val()&&(r=!0)}),(n||r?arm_lock_postSaving:arm_unlock_postSaving)(a)):arm_unlock_postSaving(a)}),jQuery(document).on("change",'input[name="paid_post_type"]',function(){var e,t="arm_pp_lock_key";jQuery(this).is(":checked")&&("buy_now"==(e=jQuery(this).val())?(arm_hide_gutenberg_notice("arm_label_blank"),""==jQuery('input[name="arm_paid_post_plan"]').val()?(arm_lock_postSaving(t),arm_display_gutenber_notice("blank_plan_amount")):ArmPlanNumberValidation(jQuery('input[name="arm_paid_post_plan"]'))?(arm_unlock_postSaving(t),arm_hide_gutenberg_notice("blank_plan_amount"),arm_hide_gutenberg_notice("invalid_plan_amount")):(arm_lock_postSaving(t),arm_hide_gutenberg_notice("blank_plan_amount"),arm_display_gutenber_notice("invalid_plan_amount"))):"free"==e?(arm_unlock_postSaving(t),arm_hide_gutenberg_notice("blank_plan_amount"),arm_hide_gutenberg_notice("invalid_plan_amount")):arm_hide_show_subscription_plan_notice())}),jQuery(document).on("keyup",".paid_subscription_options_recurring_payment_cycle_label",function(){var e,t="arm_pp_lock_key";""==jQuery(this).val()?(arm_lock_postSaving(t),arm_display_gutenber_notice("arm_label_blank")):1<jQuery(".paid_subscription_options_recurring_payment_cycle_label").length?(e=!1,jQuery(".paid_subscription_options_recurring_payment_cycle_label").each(function(){""==jQuery(this).val()&&(e=!0)}),e?(arm_lock_postSaving(t),arm_display_gutenber_notice("arm_label_blank")):(arm_unlock_postSaving(t),arm_hide_gutenberg_notice("arm_label_blank"))):(arm_unlock_postSaving(t),arm_hide_gutenberg_notice("arm_label_blank"))}),jQuery(document).on("click","#arm_add_payment_cycle_recurring",function(){arm_hide_show_subscription_plan_notice()}),jQuery(document).on("click","#arm_remove_recurring_payment_cycle",function(){arm_hide_show_subscription_plan_notice()}),jQuery(document).on("keyup",".paid_subscription_options_recurring_payment_cycle_amount",function(){var e,t,n="arm_pp_lock_key";""==jQuery(this).val()?(arm_lock_postSaving(n),arm_display_gutenber_notice("blank_plan_amount")):ArmPlanNumberValidation(this)?0<jQuery(".paid_subscription_options_recurring_payment_cycle_amount").length&&(t=e=!1,jQuery(".paid_subscription_options_recurring_payment_cycle_amount").each(function(){""==jQuery(this).val()?e=!0:ArmPlanNumberValidation(this)||(t=!0)}),e?(arm_lock_postSaving(n),arm_display_gutenber_notice("blank_plan_amount")):arm_hide_gutenberg_notice("blank_plan_amount"),t&&(arm_lock_postSaving(n),arm_display_gutenber_notice("invalid_plan_amount")),e||t||(arm_unlock_postSaving(n),arm_hide_gutenberg_notice("blank_plan_amount"),arm_hide_gutenberg_notice("invalid_plan_amount"))):(arm_lock_postSaving(n),arm_hide_gutenberg_notice("blank_plan_amount"),arm_display_gutenber_notice("invalid_plan_amount"))}),jQuery(document).on("keyup",'input[name="arm_paid_post_plan"]',function(e){var t="arm_pp_lock_key";""==jQuery(this).val()?(arm_lock_postSaving(t),arm_display_gutenber_notice("blank_plan_amount")):ArmPlanNumberValidation(this)?(arm_unlock_postSaving(t),arm_hide_gutenberg_notice("blank_plan_amount"),arm_hide_gutenberg_notice("invalid_plan_amount")):(arm_lock_postSaving(t),arm_hide_gutenberg_notice("blank_plan_amount"),arm_display_gutenber_notice("invalid_plan_amount"))});