const categoryClick = function(category) {
  // console.log('category', category);

  // [N] set s_menu_list
  $(".s_menu_list ul > li").each(function(i) {
    $(this).removeClass("s_menu_list_li-select");
    $(this).text() === category
      ? $(this).addClass("s_menu_list_li-select")
      : null;
  });

  // [N] set breadcrumb
  $(".sm_bc_cat").text(`> ${category}`);

  // [N] clean search input box
  $(".cs_bar_search_input").text("");

  d3_chart(category);
  render_ydp_list("category", category);
};

function ydp_search() {
  render_ydp_list("all", $(".cs_bar_search_input").val());
}

//[N] 渲染下方青年議題清單
const render_ydp_list = function(search_type, search_string) {
  //[N] 針對 input 內的值做 json filter
  let filter_ydp = [];
  if (search_type === "chart_search") {
    const search_cat = search_string[0];
    const search_tops = search_string[1];
    let filter_cat_ydp = ydp.filter(pj => pj.category.includes(search_cat));
    search_tops.map(top => {
      filter_ydp.push(...filter_cat_ydp.filter(pj => pj.topic.includes(top)));
    });
  } else if (search_type === "cat_inner_search") {
    const search_cat = search_string[0];
    const search_str = search_string[1];
    let filter_cat_ydp = ydp.filter(pj => pj.category.includes(search_cat));
    filter_ydp = filter_cat_ydp.filter(
      pj =>
        pj.category.includes(search_str) ||
        pj.topic.includes(search_str) ||
        pj.subtopic.includes(search_str) ||
        pj.project.includes(search_str) ||
        pj.ministry.includes(search_str) ||
        pj.stage.includes(search_str)
    );
  } else if (search_type === "category") {
    filter_ydp = ydp.filter(pj => pj.category.includes(search_string));
  } else if (search_type === "all") {
    filter_ydp = ydp.filter(
      pj =>
        pj.category.includes(search_string) ||
        pj.topic.includes(search_string) ||
        pj.subtopic.includes(search_string) ||
        pj.project.includes(search_string) ||
        pj.ministry.includes(search_string) ||
        pj.stage.includes(search_string)
    );
  }

  const noYDPinfo = `<div class="noYDPinfo"><i class="fas fa-mug-hot"></i><p>抱歉，沒有您搜尋的關鍵字</p></div>`;

  if ($(window).width() < 750) {
    let cc_blocksInfo = $.map(filter_ydp, pj => {
      return `<div class="list_block ${pj.new_subtopic === "" ? $(".select_existPJ input").prop("checked") ? null : "hidePJ" : $(".select_newPJ input").prop("checked") ? pj.category === "跨界重點議題" ? "mark_newPJ" : "newPJ" : "hidePJ"}">
								${pj.new_subtopic === "" ? "" : `<img src="./themes/responsiv-flat-test/assets/carearea/images/new.png" alt="new">`}
								<div class="list_td">
									<span class="list_hr">類別</span>
									<p>${pj.across_category === "" ? pj.category : `${pj.category} / ${pj.across_category}`}</p>
								</div>
								<div class="list_td"><span class="list_hr">主議題</span>
									<p>${pj.topic}</p>
								</div>
								<div class="list_td"><span class="list_hr">子議題</span>
									<p>${pj.subtopic}</p>
								</div>
								<div class="list_td"><span class="list_hr">計畫</span>
									<p class=${pj.link === "" ? "" : "list_href"}>${pj.link === "" ? pj.project : `<a target="_blank" rel="noopener noreferrer" href=${pj.link}>${pj.project} <i class="fas fa-arrow-right"></i></a>`}</p>
								</div>
								<div class="list_td"><span class="list_hr">提案部會</span>
									<p>${pj.ministry}</p>
								</div>
								<div class="list_td"><span class="list_hr">青年階段</span>
									<p>${pj.stage}</p>
								</div>
						</div>`;
    }).join("");
    $(".cs_list_rwd").empty();
    $(".cs_list_rwd").append(filter_ydp.length > 0 ? cc_blocksInfo : noYDPinfo);
  } else {
    //[N] 針對 filter 後的 data 做 map 表格
    let cc_blocksInfo = $.map(filter_ydp, pj => {
      return `<tr class=${pj.new_subtopic === "" ? $(".select_existPJ input").prop("checked") ? null : "hidePJ" : $(".select_newPJ input").prop("checked") ? pj.category === "跨界重點議題" ? "mark_newPJ" : pj.new_topic === "" ? "newPJ" : "newTopic" : "hidePJ"}>
							<td>${pj.across_category === "" ? pj.category : `${pj.category} / ${pj.across_category}`}</td>
							<td class="newTopic">${pj.topic}${pj.category === "跨界重點議題" ? pj.new_subtopic === "" ? "" : `<img src="./themes/responsiv-flat-test/assets/carearea/images/new.png" alt="new">` : ""}</td>
							<td>${pj.subtopic}${pj.new_subtopic === "" ? "" : pj.category === "跨界重點議題" ? "" : `<img src="./themes/responsiv-flat-test/assets/carearea/images/new.png" alt="new">`}</td>
							<td class=${pj.link === "" ? "" : "list_href"}>${pj.link === "" ? pj.project : `<a target="_blank" rel="noopener noreferrer" href=${pj.link}>${pj.project} <i class="fas fa-arrow-right"></i></a>`}</td>
							<td>${pj.ministry}</td>
							<td>${pj.stage}</td>
						</tr>`;
    }).join("");

    const table_th = `<tr><th>類別</th><th>主議題</th><th>子議題</th><th>措施/計畫/法規</th><th>提案部會</th><th>青年階段</th></tr>`;
    const cc_blocksInfo_table = `<table>${table_th}${cc_blocksInfo}</table>`;
    //[N] 渲染前先清空
    $(".cs_list").empty();
    //[N] 表單渲染
    $(".cs_list").append(
      filter_ydp.length > 0 ? cc_blocksInfo_table : noYDPinfo
    );
  }
};
