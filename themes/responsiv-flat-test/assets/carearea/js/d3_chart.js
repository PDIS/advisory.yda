const d3_chart = function(sel_category) {
  let ydp_cat_filter = ydp.filter(pj => {
    return pj.category.includes(sel_category);
  });
  // console.log("ydp_cat_filter", ydp_cat_filter);

  //[N] 統整相同主議題
  let sameTopic = [
    ...ydp_cat_filter
      .reduce((t, pj) => {
        const { topic, subtopic } = pj;
        if (!t.has(topic)) t.set(topic, { name: topic, children: [] });
        t.get(topic).children.push({ name: subtopic, ...pj });

        return t;
      }, new Map())
      .values()
  ];

  //[N] filter subtopic's children
  let set_size_sameTopic = sameTopic.map(topic => {
    let sameSubtopic = [
      ...topic.children
        .reduce((s, spj) => {
          const { subtopic, project } = spj;
          if (!s.has(subtopic))
            s.set(subtopic, { name: subtopic, s_children: [] });
          s.get(subtopic).s_children.push(spj);
          return s;
        }, new Map())
        .values()
    ];

    // console.log("sameSubtopic", sameSubtopic);

    //[N] exist all new_subtopic ?
    let new_subtopic = topic.children.filter(sp => sp.new_subtopic === "")
      .length === 0
      ? "Y"
      : "";

    return {
      ...topic,
      size: topic.children.length,
      new_subtopic,
      children: null,
      _children: sameSubtopic.map(sp => ({
        ...sp,
        // name: sp.new_subtopic === "Y" ? sp.subtopic : "",
        size: sameSubtopic.filter(ssp => ssp.name === sp.name)[0].s_children
          .length,
        level: "subtopic",
        new_subtopic: sp.s_children.filter(pj => pj.new_subtopic === "Y")
          .length > 0
          ? "Y"
          : ""
      })),
      level: "topic"
    };
  });

  const chartArray = {
    name: sel_category,
    children: set_size_sameTopic,
    size: ydp_cat_filter.length,
    level: "category"
  };

  // console.log("chartArray", chartArray);

  createCareAreaD3(chartArray);

  var currentCareAreaD3;
  function createCareAreaD3(json) {
    //[N] remove previous chartData to save memory
    if (currentCareAreaD3) currentCareAreaD3.cleanup();
    //[N] adapt layout size to the total number of elements
    var total = countElements(json);
    w = parseInt(Math.sqrt(total) * 50, 10);
    h = parseInt(Math.sqrt(total) * 50, 10);

    //[N] append multi list display check
    let color = colorData.find(color => color.category === sel_category);

    $("#d3_chart").empty();
    $("#d3_chart").append(
      `<div class="d3_chart_color_infos">
				<div class="dc_color_info color_existPJ">
					<span style="background-color:${color.color_topic}"></span>
					<p>既有議題</p>
				</div>
				<div class="dc_color_info color_newPJ">
					<span></span>
					<p>分組會議產生議題</p>
				</div>
			</div>`
    );

    //[N] create a new CodeFlower
    currentCareAreaD3 = new CareAreaD3(
      "#d3_chart",
      $(window).width() > 750
        ? $(window).width() * 0.75
        : $(window).width() * 0.9,
      550,
      color
    ).update(json);

    //[N] append RWD check topic's btns
    let rwd_topic_btns = json.children
      .map(data => ({
        name: data.name,
        new_subtopic: data.new_subtopic
      }))
      .sort((a, b) => a.name.length - b.name.length)
      .map(
        data =>
          `<span class="${data.new_subtopic === "Y" ? "rtb_new_topic" : "rtb_topic"}" >${data.name}</span>`
      );

    $(".rwd_topic_btns").empty();
    $(".rwd_topic_btns").append(rwd_topic_btns);

    $(".rwd_topic_btns span").click(function() {
      $(this).toggleClass("rtb-selected");

      const selectTopic = json.children.find(
        child => child.name === this.innerHTML
      );
      if (selectTopic._children) {
        selectTopic.children = selectTopic._children;
        selectTopic._children = null;
      } else {
        selectTopic._children = selectTopic.children;
        selectTopic.children = null;
      }

      currentCareAreaD3.update(json);

      nodeClickListRender(json, sel_category);
      nodeClickColorRender(json);
    });
  }
};
