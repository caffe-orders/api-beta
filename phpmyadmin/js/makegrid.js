function PMA_makegrid(g,v,w,B,C){var a={minColWidth:15,actionSpan:5,tableCreateTime:null,colOrder:[],colVisib:[],showAllColText:"",visibleHeadersCount:0,qtip:null,reorderHint:"",sortHint:"",markHint:"",colVisibHint:"",showReorderHint:false,showSortHint:false,showMarkHint:false,showColVisibHint:false,isCellEditActive:false,isEditCellTextEditable:false,currentEditCell:null,cellEditHint:"",gotoLinkText:"",wasEditedCellNull:false,maxTruncatedLen:0,saveCellsAtOnce:false,isCellEdited:false,saveCellWarning:"",
lastXHR:null,isSaving:false,alertNonUnique:"",token:null,server:null,db:null,table:null,dragStartRsz:function(c,b){var d=$(a.cRsz).find("div").index(b);$(b).addClass("colborder_active");a.colRsz={x0:c.pageX,n:d,obj:b,objLeft:$(b).position().left,objWidth:$(a.t).find("th.draggable:visible:eq("+d+") span").outerWidth()};$("body").css("cursor","col-resize");$("body").noSelect();a.isCellEditActive&&a.hideEditCell()},dragStartReorder:function(c,b){$(a.cCpy).text($(b).text());var d=$(b).position();$(a.cCpy).css({top:d.top+
20,left:d.left,height:$(b).height(),width:$(b).width()});$(a.cPointer).css({top:d.top});var e=a.getHeaderIdx(b);a.colReorder={x0:c.pageX,y0:c.pageY,n:e,newn:e,obj:b,objTop:d.top,objLeft:d.left};a.hideHint();$("body").css("cursor","move");$("body").noSelect();a.isCellEditActive&&a.hideEditCell()},dragMove:function(c){if(a.colRsz){var b=c.pageX-a.colRsz.x0;a.colRsz.objWidth+b>a.minColWidth&&$(a.colRsz.obj).css("left",a.colRsz.objLeft+b+"px")}else if(a.colReorder){b=c.pageX-a.colReorder.x0;$(a.cCpy).css("left",
a.colReorder.objLeft+b).show();if(c=a.getHoveredCol(c)){b=a.getHeaderIdx(c);a.colReorder.newn=b;if(b!=a.colReorder.n){var d=$(c).position();c=b<a.colReorder.n?d.left:d.left+$(c).outerWidth();$(a.cPointer).css({left:c,visibility:"visible"})}else $(a.cPointer).css("visibility","hidden")}}},dragEnd:function(c){if(a.colRsz){c=a.colRsz.objWidth+(c.pageX-a.colRsz.x0);if(c<a.minColWidth)c=a.minColWidth;a.resize(a.colRsz.n,c);a.reposRsz();a.reposDrop();a.colRsz=false;$(a.cRsz).find("div").removeClass("colborder_active")}else if(a.colReorder){if(a.colReorder.newn!=
a.colReorder.n){a.shiftCol(a.colReorder.n,a.colReorder.newn);c=$(a.colReorder.obj).position();a.colReorder.objTop=c.top;a.colReorder.objLeft=c.left;a.colReorder.n=a.colReorder.newn;a.tableCreateTime&&a.sendColPrefs();a.refreshRestoreButton()}$(a.cCpy).stop(true,true).animate({top:a.colReorder.objTop,left:a.colReorder.objLeft},"fast").fadeOut();$(a.cPointer).css("visibility","hidden");a.colReorder=false}$("body").css("cursor","inherit");$("body").noSelect(false)},resize:function(c,b){$(a.t).find("tr").each(function(){$(this).find("th.draggable:visible:eq("+
c+") span,td:visible:eq("+(a.actionSpan+c)+") span").css("width",b)})},reposRsz:function(){$(a.cRsz).find("div").hide();var c=$(a.t).find("tr:first th.draggable:visible"),b=$(a.cRsz).find("div").removeClass("condition");$(".pma_table").find("thead th:first").removeClass("before-condition");for(var d=0;d<c.length;d++){var e=$(c[d]);$(b[d]).css("left",e.position().left+e.outerWidth(true)).show();if($(c[d]).hasClass("condition")){$(b[d]).addClass("condition");d>0&&$(b[d-1]).addClass("condition")}}$(b[0]).hasClass("condition")&&
$(".pma_table").find("thead th:first").addClass("before-condition");$(a.cRsz).css("height",$(a.t).height())},shiftCol:function(c,b){$(a.t).find("tr").each(function(){b<c?$(this).find("th.draggable:eq("+b+"),td:eq("+(a.actionSpan+b)+")").before($(this).find("th.draggable:eq("+c+"),td:eq("+(a.actionSpan+c)+")")):$(this).find("th.draggable:eq("+b+"),td:eq("+(a.actionSpan+b)+")").after($(this).find("th.draggable:eq("+c+"),td:eq("+(a.actionSpan+c)+")"))});a.reposRsz();b<c?$(a.cList).find(".lDiv div:eq("+
b+")").before($(a.cList).find(".lDiv div:eq("+c+")")):$(a.cList).find(".lDiv div:eq("+b+")").after($(a.cList).find(".lDiv div:eq("+c+")"));var d=a.colOrder[c];a.colOrder.splice(c,1);a.colOrder.splice(b,0,d);if(a.colVisib.length>0){d=a.colVisib[c];a.colVisib.splice(c,1);a.colVisib.splice(b,0,d)}},getHoveredCol:function(c){var b;$headers=$(a.t).find("th.draggable:visible");$headers.each(function(){var d=$(this).offset().left,e=d+$(this).outerWidth();if(d<=c.pageX&&c.pageX<=e)b=this});return b},getHeaderIdx:function(c){return $(c).parents("tr").find("th.draggable").index(c)},
restoreColOrder:function(){for(var c=1;c<a.colOrder.length;c++){for(var b=a.colOrder[c],d=c-1;d>=0&&b<a.colOrder[d];)d--;d!=c-1&&a.shiftCol(c,d+1)}a.tableCreateTime&&a.sendColPrefs();a.refreshRestoreButton()},sendColPrefs:function(){if($(a.t).is(".ajax")){var c={ajax_request:true,db:a.db,table:a.table,token:a.token,server:a.server,set_col_prefs:true,table_create_time:a.tableCreateTime};a.colOrder.length>0&&$.extend(c,{col_order:a.colOrder.toString()});a.colVisib.length>0&&$.extend(c,{col_visib:a.colVisib.toString()});
$.post("sql.php",c,function(b){if(b.success!=true){var d=$(document.createElement("div"));d.html(b.error);d.addClass("error");PMA_ajaxShowMessage(d,false)}})}},refreshRestoreButton:function(){for(var c=true,b=0;b<a.colOrder.length;b++)if(a.colOrder[b]!=b){c=false;break}b=a.visibleHeadersCount==1;c||b?$(".restore_column").hide():$(".restore_column").show()},updateHint:function(c){if(!a.colRsz&&!a.colReorder){var b="";if(a.showReorderHint&&a.reorderHint)b+=a.reorderHint;if(a.showSortHint&&a.sortHint){b+=
b.length>0?"<br />":"";b+=a.sortHint}if(a.showMarkHint&&a.markHint&&!a.showSortHint){b+=b.length>0?"<br />":"";b+=a.markHint}if(a.showColVisibHint&&a.colVisibHint){b+=b.length>0?"<br />":"";b+=a.colVisibHint}if(a.qtip){a.qtip.disable(!b&&c.type=="mouseenter");a.qtip.updateContent(b,false)}}else a.hideHint()},hideHint:function(){if(a.qtip){a.qtip.hide();a.qtip.disable(true)}},toggleCol:function(c){if(a.colVisib[c])if(a.visibleHeadersCount>1){$(a.t).find("tr").each(function(){$(this).find("th.draggable:eq("+
c+"),td:eq("+(a.actionSpan+c)+")").hide()});a.colVisib[c]=0;$(a.cList).find(".lDiv div:eq("+c+") input").removeAttr("checked")}else{$(a.cList).find(".lDiv div:eq("+c+") input").attr("checked","checked");return false}else{$(a.t).find("tr").each(function(){$(this).find("th.draggable:eq("+c+"),td:eq("+(a.actionSpan+c)+")").show()});a.colVisib[c]=1;$(a.cList).find(".lDiv div:eq("+c+") input").attr("checked","checked")}return true},afterToggleCol:function(){a.reposRsz();a.reposDrop();a.sendColPrefs();
a.visibleHeadersCount=$(a.t).find("tr:first th.draggable:visible").length;a.refreshRestoreButton()},showColList:function(c){if(!a.colRsz&&!a.colReorder){var b=$(c).position();if(b.left+$(a.cList).outerWidth(true)>$(document).width())b.left=$(document).width()-$(a.cList).outerWidth(true);$(a.cList).css({left:b.left,top:b.top+$(c).outerHeight(true)}).show();$(c).addClass("coldrop-hover")}},hideColList:function(){$(a.cList).hide();$(a.cDrop).find(".coldrop-hover").removeClass("coldrop-hover")},reposDrop:function(){for(var c=
$(g).find("th:not(.draggable)"),b=0;b<c.length;b++){var d=$(a.cDrop).find("div:eq("+b+")"),e=$(c[b]).position();d.css({left:e.left+$(c[b]).width()-d.width(),top:e.top})}},showAllColumns:function(){for(var c=0;c<a.colVisib.length;c++)a.colVisib[c]||a.toggleCol(c);a.afterToggleCol()},showEditCell:function(c){if($(c).is(".grid_edit")&&!a.colRsz&&!a.colReorder)if(!a.isCellEditActive){var b=$(c);$(a.cEdit).find(".edit_area").empty().hide();$(a.cEdit).css({top:b.position().top,left:b.position().left}).show().find(".edit_box").css({width:b.outerWidth(),
height:b.outerHeight()});b=PMA_getCellValue(c);$(a.cEdit).find(".edit_box").val(b);a.currentEditCell=c;$(a.cEdit).find(".edit_box").focus();$(a.cEdit).find("*").removeAttr("disabled")}},hideEditCell:function(c,b){if(a.isCellEditActive&&!c)a.saveOrPostEditedCell();else{if(a.lastXHR!=null){a.lastXHR.abort();a.lastXHR=null}if(b){if(a.currentEditCell){var d=$(a.currentEditCell);if(d.data("value")==null){d.find("span").html("NULL");d.addClass("null")}else{d.removeClass("null");var e=d.data("value");if(d.is(".truncated"))if(e.length>
a.maxTruncatedLen)e=e.substring(0,a.maxTruncatedLen)+"...";d.find("span").text(e)}}b.transformations!=undefined&&$.each(b.transformations,function(f,i){$(a.t).find(".to_be_saved:eq("+f+")").find("span").html(i)});b.relations!=undefined&&$.each(b.relations,function(f,i){$(a.t).find(".to_be_saved:eq("+f+")").find("span").html(i)});a.reposRsz();a.reposDrop()}$(a.cEdit).hide();$(a.cEdit).find(".edit_box").blur();a.isCellEditActive=false;a.currentEditCell=null;d=$(a.cEdit).find(".hasDatepicker");if(d.length>
0){d.datepicker("destroy");$(a.cEdit).find(".edit_box").css("cursor","inherit")}}},showEditArea:function(){if(!a.isCellEditActive){a.isCellEditActive=true;a.isEditCellTextEditable=false;var c=$(a.currentEditCell),b=$(a.cEdit).find(".edit_area"),d=c.parent("tr").find(".where_clause").val(),e=getFieldName(c),f=c.text(),i=c.find("a").attr("title"),n=c.find("span").text();b.empty();if(c.find("a").length>0){var p=document.createElement("div");p.className="goto_link";$(p).append(a.gotoLinkText+": ").append(c.find("a").clone());
b.append(p)}a.wasEditedCellNull=false;if(c.is(":not(.not_null)")){b.append('<div class="null_div">Null :<input type="checkbox"></div>');var m=b.find(".null_div input");if(c.is(".null")){m.attr("checked",true);a.wasEditedCellNull=true}if(c.is(".enum, .set"))b.find("select").live("change",function(){m.attr("checked",false)});else if(c.is(".relation")){b.find("select").live("change",function(){m.attr("checked",false)});b.find(".browse_foreign").live("click",function(){m.attr("checked",false)})}else{$(a.cEdit).find(".edit_box").live("keypress change",
function(){m.attr("checked",false)});b.find("textarea").live("keydown",function(){m.attr("checked",false)})}m.click(function(){if(c.is(".enum"))b.find("select").attr("value","");else if(c.is(".set"))b.find("select").find("option").each(function(){$(this).attr("selected",false)});else if(c.is(".relation"))b.find("select").length>0&&b.find("select").attr("value","");else b.find("textarea").val("");$(a.cEdit).find(".edit_box").val("")})}if(c.is(".relation")){b.addClass("edit_area_loading");c.data("original_data",
null);d={ajax_request:true,get_relational_values:true,server:a.server,db:a.db,table:a.table,column:e,token:a.token,curr_value:f,relation_key_or_display_column:i};a.lastXHR=$.post("sql.php",d,function(h){a.lastXHR=null;b.removeClass("edit_area_loading");if($(h.dropdown).is("select")){var x=$(h.dropdown).val();c.data("original_data",x);$(a.cEdit).find(".edit_box").val(x)}b.append(h.dropdown);b.append('<div class="cell_edit_hint">'+a.cellEditHint+"</div>")});b.show();b.find("select").live("change",function(){$(a.cEdit).find(".edit_box").val($(this).val())})}else if(c.is(".enum")){b.addClass("edit_area_loading");
d={ajax_request:true,get_enum_values:true,server:a.server,db:a.db,table:a.table,column:e,token:a.token,curr_value:n};a.lastXHR=$.post("sql.php",d,function(h){a.lastXHR=null;b.removeClass("edit_area_loading");b.append(h.dropdown);b.append('<div class="cell_edit_hint">'+a.cellEditHint+"</div>")});b.show();b.find("select").live("change",function(){$(a.cEdit).find(".edit_box").val($(this).val())})}else if(c.is(".set")){b.addClass("edit_area_loading");d={ajax_request:true,get_set_values:true,server:a.server,
db:a.db,table:a.table,column:e,token:a.token,curr_value:n};a.lastXHR=$.post("sql.php",d,function(h){a.lastXHR=null;b.removeClass("edit_area_loading");b.append(h.select);b.append('<div class="cell_edit_hint">'+a.cellEditHint+"</div>")});b.show();b.find("select").live("change",function(){$(a.cEdit).find(".edit_box").val($(this).val())})}else if(c.is(".truncated, .transformed")){if(c.is(".to_be_saved")){d=c.data("value");$(a.cEdit).find(".edit_box").val(d);b.append("<textarea></textarea>");b.find("textarea").val(d).live("keyup",
function(){$(a.cEdit).find(".edit_box").val($(this).val())});$(a.cEdit).find(".edit_box").live("keyup",function(){b.find("textarea").val($(this).val())});b.append('<div class="cell_edit_hint">'+a.cellEditHint+"</div>")}else{b.addClass("edit_area_loading");c.data("original_data",null);d="SELECT `"+e+"` FROM `"+a.table+"` WHERE "+PMA_urldecode(d);a.lastXHR=$.post("sql.php",{token:a.token,server:a.server,db:a.db,ajax_request:true,sql_query:d,grid_edit:true},function(h){a.lastXHR=null;b.removeClass("edit_area_loading");
if(h.success==true){if(c.is(".truncated"))a.maxTruncatedLen=$(a.currentEditCell).text().length-3;c.data("original_data",h.value);$(a.cEdit).find(".edit_box").val(h.value);b.append("<textarea></textarea>");b.find("textarea").val(h.value).live("keyup",function(){$(a.cEdit).find(".edit_box").val($(this).val())});$(a.cEdit).find(".edit_box").live("keyup",function(){b.find("textarea").val($(this).val())});b.append('<div class="cell_edit_hint">'+a.cellEditHint+"</div>")}else PMA_ajaxShowMessage(h.error,
false)});b.show()}a.isEditCellTextEditable=true}else if(c.is(".datefield, .datetimefield, .timestampfield")){d=$(a.cEdit).find(".edit_box");e=c.is(".null");f=!e?d.val():"";i=true;if(c.is(".datefield"))i=false;PMA_addDatepicker(b,{altField:d,showTimepicker:i,onSelect:function(){$(a.cEdit).find(".null_div input[type=checkbox]").attr("checked",false)}});b.find("> *").click(function(h){h.stopPropagation()});e?d.val(""):b.datetimepicker("setDate",f);b.append('<div class="cell_edit_hint">'+a.cellEditHint+
"</div>")}else{a.isEditCellTextEditable=true;b.children().length>0&&b.append('<div class="cell_edit_hint">'+a.cellEditHint+"</div>")}b.children().length>0&&b.show()}},postEditedCell:function(){if(!a.isSaving){a.isSaving=true;var c={},b=$("#relational_display_K").attr("checked")?"K":"D",d={},e=false,f="",i="",n=[],p=$(".edit_row_anchor").is(".nonunique")?0:1,m=[],h=[],x=[];p||alert(a.alertNonUnique);$(".to_be_saved").parents("tr").each(function(){var j=$(this),q=j.find(".where_clause").val();n.push(PMA_urldecode(q));
var o=jQuery.parseJSON(j.find(".condition_array").val()),r=[],y=[],s=[];j.find(".to_be_saved").each(function(){var k=$(this),t=getFieldName(k),z={};if(k.is(".transformed"))e=true;z[t]=k.data("value");var E=z[t]===null;r.push(t);if(E){s.push("on");y.push("")}else{s.push("");y.push(k.data("value"));var D=k.index(".to_be_saved");if(k.is(":not(.relation, .enum, .set, .bit)")){if(k.is(".transformed")){d[D]={};$.extend(d[D],z)}}else if(k.is(".relation")){c[D]={};$.extend(c[D],z)}}if(q.indexOf(PMA_urlencode(t))>
-1){k="`"+a.table+"`.`"+t+"`";for(var F in o)if(F.indexOf(k)>-1){o[F]=E?"IS NULL":"= '"+z[t].replace(/'/g,"''")+"'";break}}});var l="",A;for(A in o)l+=A+" "+o[A]+" AND ";l=l.substring(0,l.length-5);l=PMA_urlencode(l);j.data("new_clause",l);j.find(".condition_array").val(JSON.stringify(o));m.push(r);h.push(y);x.push(s)});f=$.param(c);i=$.param(d);b={ajax_request:true,sql_query:"",token:a.token,server:a.server,db:a.db,table:a.table,clause_is_unique:p,where_clause:n,"fields[multi_edit]":h,"fields_name[multi_edit]":m,
"fields_null[multi_edit]":x,rel_fields_list:f,do_transformations:e,transform_fields_list:i,relational_display:b,"goto":"sql.php",submit_type:"save"};if(a.saveCellsAtOnce)$(".save_edited").addClass("saving_edited_data").find("input").attr("disabled","disabled");else{$(a.cEdit).find("*").attr("disabled","disabled");$(a.cEdit).find(".edit_area");$(a.cEdit).find(".edit_box").addClass("edit_box_posting")}$.ajax({type:"POST",url:"tbl_replace.php",data:b,success:function(j){a.isSaving=false;if(a.saveCellsAtOnce)$(".save_edited").removeClass("saving_edited_data").find("input").removeAttr("disabled");
else{$(a.cEdit).find("*").removeAttr("disabled");$(a.cEdit).find(".edit_box").removeClass("edit_box_posting")}if(j.success==true){PMA_ajaxShowMessage(j.message);$(".to_be_saved").parents("tr").each(function(){var q=$(this).data("new_clause"),o=$(this).find(".where_clause"),r=o.attr("value"),y=PMA_urldecode(r),s=PMA_urldecode(q);o.attr("value",q);$(this).find("a").each(function(){$(this).attr("href",$(this).attr("href").replace(r,q));$(this).attr("href").indexOf("DELETE")>-1&&$(this).removeAttr("onclick").unbind("click").bind("click",
function(){return confirmLink(this,"DELETE FROM `"+a.db+"`.`"+a.table+"` WHERE "+s+(p?"":" LIMIT 1"))})});$(this).find("input[type=checkbox]").each(function(){var l=$(this),A=l.attr("name"),k=l.attr("value");l.attr("name",A.replace(r,q));l.attr("value",k.replace(y,s))})});$("#result_query").remove();typeof j.sql_query!="undefined"&&$("#sqlqueryresults").prepend(j.sql_query);a.hideEditCell(true,j);$(".save_edited").hide();$(a.t).find(".to_be_saved").removeClass("to_be_saved").data("value",null).data("original_data",
null);a.isCellEdited=false}else PMA_ajaxShowMessage(j.error,false)}})}},saveEditedCell:function(){var c=$(a.currentEditCell),b="",d=false,e=getFieldName(c),f={};b=$(a.cEdit).find("input:checkbox").is(":checked");if($(a.cEdit).find(".edit_area").is(".edit_area_loading"))d=false;else if(b){if(!a.wasEditedCellNull){f[e]=null;d=true}}else{if(c.is(".bit"))f[e]="0b"+$(a.cEdit).find(".edit_box").val();else if(c.is(".set")){b=$(a.cEdit).find("select");f[e]=b.map(function(){return $(this).val()}).get().join(",")}else if(c.is(".relation, .enum")){b=
$(a.cEdit).find("select");if(b.length!=0)f[e]=b.val();b=$(a.cEdit).find("span.curr_value");if(b.length!=0)f[e]=b.text()}else f[e]=$(a.cEdit).find(".edit_box").val();if(a.wasEditedCellNull||f[e]!=PMA_getCellValue(a.currentEditCell))d=true}if(d){$(a.currentEditCell).addClass("to_be_saved").data("value",f[e]);a.saveCellsAtOnce&&$(".save_edited").show();a.isCellEdited=true}return d},saveOrPostEditedCell:function(){var c=a.saveEditedCell();if(a.saveCellsAtOnce)c?a.hideEditCell(true,true):a.hideEditCell(true);
else c?a.postEditedCell():a.hideEditCell(true)},initColResize:function(){a.cRsz=document.createElement("div");a.cRsz.className="cRsz";$(a.t).find("tr:first th.draggable").each(function(){var c=document.createElement("div");$(c).addClass("colborder").mousedown(function(b){a.dragStartRsz(b,this)});$(a.cRsz).append(c)});a.reposRsz();$(a.gDiv).prepend(a.cRsz)},initColReorder:function(){a.cCpy=document.createElement("div");a.cPointer=document.createElement("div");a.cCpy.className="cCpy";$(a.cCpy).hide();
a.cPointer.className="cPointer";$(a.cPointer).css("visibility","hidden");a.reorderHint=PMA_messages.strColOrderHint;var c=$(a.t).find("tr:first th.draggable");$col_order=$("#col_order");if($col_order.length>0){a.colOrder=$col_order.val().split(",");for(var b=0;b<a.colOrder.length;b++)a.colOrder[b]=parseInt(a.colOrder[b])}else{a.colOrder=[];for(b=0;b<c.length;b++)a.colOrder.push(b)}$(g).find("th.draggable").mousedown(function(d){a.visibleHeadersCount>1&&a.dragStartReorder(d,this)}).mouseenter(function(){if(a.visibleHeadersCount>
1){a.showReorderHint=true;$(this).css("cursor","move")}else $(this).css("cursor","inherit")}).mouseleave(function(){a.showReorderHint=false});$(".restore_column").click(function(){a.restoreColOrder()});$(a.gDiv).append(a.cPointer);$(a.gDiv).append(a.cCpy);$(g).find("th a").bind("dragstart",function(){return false});a.refreshRestoreButton()},initColVisib:function(){a.cDrop=document.createElement("div");a.cList=document.createElement("div");a.cDrop.className="cDrop";a.cList.className="cList";$(a.cList).hide();
a.colVisibHint=PMA_messages.strColVisibHint;a.showAllColText=PMA_messages.strShowAllCol;var c=$(a.t).find("tr:first th.draggable"),b=$("#col_visib");if(b.length>0){a.colVisib=b.val().split(",");for(b=0;b<a.colVisib.length;b++)a.colVisib[b]=parseInt(a.colVisib[b])}else{a.colVisib=[];for(b=0;b<c.length;b++)a.colVisib.push(1)}if(c.length>1){b=$(a.t).find("th:not(.draggable)");PMA_createqTip(b);b.each(function(){var i=$(this),n=document.createElement("div");i.position();$(n).addClass("coldrop").click(function(){a.cList.style.display==
"none"?a.showColList(this):a.hideColList()});$(a.cDrop).append(n)}).mouseenter(function(){a.showColVisibHint=true}).mouseleave(function(){a.showColVisibHint=false});a.cList.innerHTML='<div class="lDiv"></div>';var d=$(a.cList).find("div");for(b=0;b<c.length;b++){var e=c[b],f=document.createElement("div");$(f).text($(e).text()).prepend('<input type="checkbox" '+(a.colVisib[b]?'checked="checked" ':"")+"/>");d.append(f);$(f).click(function(){a.toggleCol($(this).index())&&a.afterToggleCol()})}b=document.createElement("div");
$(b).addClass("showAllColBtn").text(a.showAllColText);$(a.cList).append(b);$(b).click(function(){a.showAllColumns()});if(c.length>10){c=b.cloneNode(true);$(a.cList).prepend(c);$(c).click(function(){a.showAllColumns()})}}$(g).find("td, th.draggable").mouseenter(function(){a.hideColList()});$(a.gDiv).append(a.cDrop);$(a.gDiv).append(a.cList);a.reposDrop()},initGridEdit:function(){a.cEdit=document.createElement("div");a.cEdit.className="cEdit";$(a.cEdit).html('<textarea class="edit_box" rows="1" ></textarea><div class="edit_area" />');
$(a.cEdit).hide();a.cellEditHint=PMA_messages.strCellEditHint;a.saveCellWarning=PMA_messages.strSaveCellWarning;a.alertNonUnique=PMA_messages.strAlertNonUnique;a.gotoLinkText=PMA_messages.strGoToLink;a.saveCellsAtOnce=$("#save_cells_at_once").val();$(g).find("td.data").click(function(c){a.isCellEditActive?a.saveOrPostEditedCell():a.showEditCell(this);c.stopPropagation();$(c.target).is("a")&&c.preventDefault()});$(a.cEdit).find(".edit_box").focus(function(){a.showEditArea()});$(a.cEdit).find(".edit_box, select").live("keydown",
function(c){if(c.which==13){c.preventDefault();a.saveOrPostEditedCell()}});$(a.cEdit).keydown(function(c){a.isEditCellTextEditable||c.preventDefault()});$("html").click(function(c){$(c.target).parents().index(a.cEdit)==-1&&a.hideEditCell()});$("html").keydown(function(c){c.which==27&&a.isCellEditActive&&a.hideEditCell(true)});$(".save_edited").click(function(){a.hideEditCell();a.postEditedCell()});$(window).bind("beforeunload",function(){if(a.isCellEdited)return a.saveCellWarning});$(a.gDiv).append(a.cEdit);
PMA_createqTip($(a.t).find(".edit_row_anchor a"),PMA_messages.strGridEditFeatureHint)}};$(g).find("th, td:not(:has(span))").wrapInner("<span />");a.gDiv=document.createElement("div");a.t=g;var u=$(g).find("tr:first th.draggable");a.visibleHeadersCount=u.filter(":visible").length;a.actionSpan=$(g).find("tr:first th:first").hasClass("draggable")?0:$(g).find("tr:first th:first").prop("colspan");a.tableCreateTime=$("#table_create_time").val();a.sortHint=PMA_messages.strSortHint;a.markHint=PMA_messages.strColMarkHint;
u=$(".common_hidden_inputs");a.token=u.find("input[name=token]").val();a.server=u.find("input[name=server]").val();a.db=u.find("input[name=db]").val();a.table=u.find("input[name=table]").val();$(g).addClass("pma_table");$(a.gDiv).css("position","relative");$(g).before(a.gDiv);$(a.gDiv).append(g);v=v==undefined?true:v;w=w==undefined?true:w;B=B==undefined?true:B;C=C==undefined?true:C;v&&a.initColResize();w&&$(".navigation").length>0&&a.initColReorder();B&&a.initColVisib();C&&$(g).is(".ajax")&&a.initGridEdit();
PMA_createqTip($(g).find("th.draggable"));$(g).find("th.draggable a").attr("title","").mouseenter(function(c){a.showSortHint=true;a.updateHint(c)}).mouseleave(function(c){a.showSortHint=false;a.updateHint(c)});$(g).find("th.marker").mouseenter(function(){a.showMarkHint=true}).mouseleave(function(){a.showMarkHint=false});if(v||w){$(document).mousemove(function(c){a.dragMove(c)});$(document).mouseup(function(c){a.dragEnd(c)})}$(g).find("th").mouseenter(function(c){a.qtip=$(this).qtip("api");a.updateHint(c)}).mouseleave(function(c){a.updateHint(c)});
$(g).removeClass("data");$(a.gDiv).addClass("data")};
