const render_bodyInner = function(inner) {
  $("#ydp_index").empty();
  const countingCase_inner = `<div id="countingCase">
	<div class="countingCase_header">
		<h2>關於青年發展議題圖象盤點案</h2>
		<p>為釐清青年發展議題圖象，由政府各部會及行政院青年諮詢委員會委員共同協作盤點現階段青年發展所需處理議題，以利作為規劃青年施政方向參考</p>
	</div>

	<div class="countingCase_body">
		<div class="s_menu">
			<div class="s_menu_breadcrumb">目前位置 : 首頁 <span>類別</span></div>
			<div class="s_menu_list">
				<ul>
					<li class="s_menu_list_li" onClick="ydp_inner_change('教育')">教育</li>
					<li class="s_menu_list_li" onClick="ydp_inner_change('健康')">健康</li>
					<li class="s_menu_list_li" onClick="ydp_inner_change('家庭')">家庭</li>
					<li class="s_menu_list_li" onClick="ydp_inner_change('經濟機會')">經濟機會</li>
					<li class="s_menu_list_li" onClick="ydp_inner_change('跨界重點議題')">跨界重點議題</li>
					<li class="s_menu_list_li" onClick="ydp_inner_change('公民與社會參與')">公民與社會參與</li>
					<li class="s_menu_list_li" onClick="ydp_inner_change('國際視野與經驗')">國際視野與經驗</li>
				</ul>
			</div>
			<div class="countingCase_info" onClick="ydp_inner_change('careArea')">關於青年發展議題-我們關心的領域<i class="fas fa-question-circle"></i></a></div>
			<p>為釐清青年發展議題圖象，由政府各部會及行政院青年諮詢委員會委員共同協作盤點現階段青年發展所需處理議題，以利作為規劃青年施政方向參考</p>
		</div><!-- s_menu -->

		<div class="countingCase_container">
			<div class="cc_blocks">
					<!-- [R] append countingCaseInfo -->
			</div><!-- cc_blocks -->
		</div><!-- countingCase_container -->
	</div><!-- countingCase_body -->
</div>`;

  const careArea_inner = `<div id="careArea">
	<div class="careArea_header">
		<h2>我們關心的領域</h2>
	</div>

	<div class="careArea_body">
		<div class="s_menu">
			<div class="s_menu_breadcrumb">目前位置 :  <a onClick="render_bodyInner('careArea')">首頁</a> <span class="sm_bc_cat"></span> <span class="sm_bc_topic"></span>
				<span class="sm_bc_subtopic"></span></div>
			<div class="s_menu_list">
				<ul>
					<li class="s_menu_list_li" onClick="categoryClick('教育')">教育</li>
					<li class="s_menu_list_li" onClick="categoryClick('健康')">健康</li>
					<li class="s_menu_list_li" onClick="categoryClick('家庭')">家庭</li>
					<li class="s_menu_list_li" onClick="categoryClick('經濟機會')">經濟機會</li>
					<li class="s_menu_list_li" onClick="categoryClick('跨界重點議題')">跨界重點議題</li>
					<li class="s_menu_list_li" onClick="categoryClick('公民與社會參與')">公民與社會參與</li>
					<li class="s_menu_list_li" onClick="categoryClick('國際視野與經驗')">國際視野與經驗</li>
				</ul>
			</div>
			<div class="careArea_info" onClick="ydp_inner_change('countingCase')">關於青年發展議題圖象盤點案<i class="fas fa-question-circle"></i></div>
		</div><!-- s_menu -->

		<div class="careArea_chart">
			<div class="careArea_container" id="d3_chart">
				<!-- [R] append hexagon -->
			</div><!-- careArea_container -->

			<div class="careArea_infoPopup">
				<div class="careArea_infoPopup_block">
					<!-- [R] append infoPopup_block -->
				</div>
				<span class="careArea_infoPopup_close_btn" onclick="$('.careArea_infoPopup').removeClass('careArea_infoPopup-open')"><i class="far fa-times-circle"></i></span>
			</div><!-- careArea_infoPopup -->

		</div><!-- careArea_chart -->


		<div class="rwd_topic_btns">
			<!-- [R] append rwd_topic_btns -->
		</div>

	</div><!-- careArea_body -->

	<div class="careArea_search_body">
		<div class="cs_bar">
			<div class="cs_bar_search">
				<input class="cs_bar_search_input" type="text" placeholder="輸入關鍵字，ex 教育">
				<div class="cs_bar_search_btn" onclick="ydp_search()">搜尋</div>
				<span class="cs_bar_search_btn_rwd" onclick="ydp_search()"><i class="fas fa-search"></i></span>

			</div>
			<div class="cs_bar_adSelect">
				<label class="adSelect select_existPJ">
					<input type="checkbox" name="select_pj" checked value="select_existPJ">既有議題
					<span class="checkmark"></span>
				</label>
				<label class="adSelect select_newPJ">
					<input type="checkbox" name="select_pj" checked value="select_newPJ">分組會議產生議題
					<span class="checkmark"></span>
				</label>
			</div>
		</div><!-- cs_bar -->


		<div class="cs_list">
			<!-- [R] remder list -->
		</div><!-- cs_list -->

		<div class="cs_list_rwd">
			<!-- [R] remder list_rwd -->
		</div><!-- careArea_search_body -->


	</div>
</div>`;
  if (inner === "countingCase") {
    $("#ydp_index").append(countingCase_inner);
    render_cc_blocksInfo();
  } else if (inner === "careArea") {
    $("#ydp_index").append(careArea_inner);
    hexagon();
  } else {
    $("#ydp_index").append(careArea_inner);
    categoryClick(inner);
  }

  // [N]listen checkbox onchange
  $("input[name=select_pj]").change(function() {
    ydp_search();
  });
};

function ydp_inner_change(inner) {
  render_bodyInner(inner);
}
