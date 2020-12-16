var CareAreaD3 = function(selector, w, h, color) {
  this.w = w;
  this.h = h;

  this.color = color;

  d3.select(selector).selectAll("svg").remove();

  this.svg = d3
    .select(selector)
    .append("svg:svg")
    .attr("width", w)
    .attr("height", h);

  this.svg
    .append("svg:rect")
    .style("stroke", "transparent")
    .style("fill", "transparent")
    .attr("width", w)
    .attr("height", h);

  this.force = d3.layout
    .force()
    .on("tick", this.tick.bind(this))
    .charge(function(d) {
      // 擴展彈跳層度
      return -20;
      // return d._children ? -d.size / 100 : -40;
    })
    .linkDistance(function(d) {
      //線的距離
      return w > 750
        ? d.target._children ? 180 : 100
        : d.target._children ? 100 : 40;
      // return d.target.children ? 180 : 100;
      // return d.target._children ? 80 : 25;
    })
    .size([h, w]);
};

CareAreaD3.prototype.update = function(json) {
  if (json) this.json = json;

  this.json.fixed = true;
  this.json.x = this.w / 2;
  this.json.y = this.h / 2;

  var nodes = this.flatten(this.json);
  var links = d3.layout.tree().links(nodes);
  var total = nodes.length || 1;

  // remove existing text (will readd it afterwards to be sure it's on top)
  this.svg.selectAll("text").remove();

  // Restart the force layout
  this.force
    .gravity(0)
    // .gravity(Math.atan(total / 50) / Math.PI * 0.4)
    .nodes(nodes)
    .links(links)
    .start();

  // Update the links
  this.link = this.svg.selectAll("line.link").data(links, function(d) {
    return d.target.name;
  });

  // Enter any new links
  this.link
    .enter()
    .insert("svg:line", ".node")
    .attr("class", "link")
    .attr("x1", d => d.source.x)
    .attr("y1", d => d.source.y)
    .attr("x2", d => d.target.x)
    .attr("y2", d => d.target.y);

  // Exit any old links.
  this.link.exit().remove();

  // Update the nodes
  this.node = this.svg
    .selectAll("circle.node")
    .data(nodes, d => d.name)
    .classed("collapsed", d => (d._children ? 1 : 0));

  this.node
    .transition()
    .attr(
      "r",
      d => (d.level === "category" ? 15 : d.level === "topic" ? 10 : 6)
    );

  // Enter any new nodes
  this.node
    .enter()
    .append("svg:circle")
    .attr("class", "node")
    .classed("directory", d => (d._children || d.children ? 1 : 0))
    .attr(
      "name",
      d =>
        `circle_${d.level}_${d.name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "")}`
    )
    .attr(
      "r",
      d => (d.level === "category" ? 15 : d.level === "topic" ? 10 : 6)
    )
    .style(
      "fill",
      d =>
        (d.name === this.color.category
          ? this.color.color_cat
          : d.new_subtopic === "" ? this.color.color_topic : "#ffe59e")
    )
    .call(this.force.drag)
    .on("click", this.click.bind(this))
    .on("mouseover", this.mouseover.bind(this))
    .on("mouseout", this.mouseout.bind(this));

  // Exit any old nodes
  this.node.exit().remove();

  //
  // Update the texts
  this.text = this.svg
    .selectAll("circle.nodetext")
    .data(nodes, d => d.name)
    .classed("collapsed", d => (d._children ? 1 : 0))
    .text(d => `${d.name}`)
    .attr("dy", d => d.x)
    .attr("dx", d => d.y)
    .attr("text-anchor", "middle")
    .attr("font-weight", d => (d.new_subtopic === "Y" ? "bold" : "normal"));

  this.text.transition().attr("r", d => (d.size > 20 ? 20 : 10));

  // Enter any new texts
  this.text
    .enter()
    .append("svg:text")
    .attr("class", "nodetext")
    .classed("directory", d => (d._children || d.children ? 1 : 0))
    .text(d => d.name)
    .attr(
      "name",
      d => `text_${d.level}_${d.name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "")}`
    )
    .attr("dy", d => (d.size > 20 ? 20 : 10) * -1.6)
    .attr("dx", d => 0)
    .attr("text-anchor", "middle")
    .attr("font-weight", d => (d.new_subtopic === "Y" ? "bold" : "normal"))
    .call(this.force.drag);

  // Exit any old text
  this.text.exit().remove();

  return this;
};

CareAreaD3.prototype.flatten = function(root) {
  var nodes = [], i = 0;

  function recurse(node) {
    if (node.children) {
      node.size = node.children.reduce(function(p, v) {
        return p + recurse(v);
      }, 0);
    }
    if (!node.id) node.id = ++i;
    nodes.push(node);
    return node.size;
  }

  root.size = recurse(root);
  return nodes;
};

CareAreaD3.prototype.click = function clickclick(d) {
  //[N] opne topic's subtopic
  if ($(window).width() > 750) {
    if (d._children) {
      // Toggle children on click.
      d.children = d._children;
      d._children = null;
    } else {
      d._children = d.children;
      d.children = null;
    }
    this.update();

    nodeClickListRender(this.json, this.color.category);
    nodeClickColorRender(this.json);
  }

  //[N]display subtopic's info
  if (d.s_children) {
    let subtopicInfos = d.s_children
      .map(node => {
        return node.category === "跨界重點議題"
          ? `<div class="info_block">此為新增議題，目前尚未有計劃</div>`
          : node.new_subtopic === "Y"
              ? `<div class="info_block">新議題！</div>`
              : `<div class="info_block">
									<div class="list_td"><span class="list_hr">計畫</span>
										<p>${node.project}</p>
									</div>
									<div class="list_td"><span class="list_hr">提案部會</span>
										<p>${node.ministry}</p>
									</div>
									<div class="list_td"><span class="list_hr">青年階段</span>
										<p>${node.stage}</p>
									</div>
								</div>`;
      })
      .join("");
    let subtopicInfo = `<div class="info_blocks">
				<h5>${d.name}</h5>
				${subtopicInfos}
			</div>`;
    $(".careArea_infoPopup_block").empty();
    $(".careArea_infoPopup").addClass("careArea_infoPopup-open");
    $(".careArea_infoPopup_block").append(subtopicInfo);
  } else {
    $(".careArea_infoPopup").removeClass("careArea_infoPopup-open");
  }
};

function nodeClickListRender(json, category) {
  //[N] reRender the list
  let search_topics = json.children
    .filter(topic => topic.children !== null)
    .map(tp => tp.name);

  search_topics.length > 0
    ? render_ydp_list("chart_search", [category, search_topics])
    : render_ydp_list("category", category);

  $(".sm_bc_topic").text(`> ${search_topics.join(",")}`);
}
function nodeClickColorRender(json) {
  //[N] Focuse on node color
  $("circle").attr("fill-opacity", 0.2);
  $("text").attr("fill-opacity", 0.2);
  //[N] filter open topic's nodes
  const nodeOpenList = json.children.filter(topic => topic.children !== null);

  if (nodeOpenList.length > 0) {
    nodeOpenList.map(topic => {
      $(
        `text[name=text_${topic.level}_${topic.name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "")}]`
      ).attr("fill-opacity", 1);
      $(
        `circle[name=circle_${topic.level}_${topic.name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "")}]`
      ).attr("fill-opacity", 1);
      topic.children === null
        ? null
        : topic.children.map(subtopic => {
            $(
              `text[name=text_${subtopic.level}_${subtopic.name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "")}]`
            ).attr("fill-opacity", 1);
            $(
              `circle[name=circle_${subtopic.level}_${subtopic.name.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "")}]`
            ).attr("fill-opacity", 1);
          });

      // console.log($(`text[name=text_subtopic_${subtopic.name}]`));
    });
  } else {
    $("circle").attr("fill-opacity", 1);
    $("text").attr("fill-opacity", 1);
  }
}

CareAreaD3.prototype.mouseover = function(d) {
  $("text")
    .filter(function() {
      return $(this).text() === d.name;
    })
    .attr("font-weight", "bold");
};

CareAreaD3.prototype.mouseout = function(d) {
  d.new_subtopic === "Y"
    ? null
    : $("text")
        .filter(function() {
          return $(this).text() === d.name;
        })
        .attr("font-weight", "normal");
};

CareAreaD3.prototype.tick = function() {
  var h = this.h;
  var w = this.w;
  this.link
    .attr("x1", d => d.source.x)
    .attr("y1", d => d.source.y)
    .attr("x2", d => d.target.x)
    .attr("y2", d => d.target.y);

  this.node.attr("transform", function(d) {
    return `translate(${Math.max(5, Math.min(w - 5, d.x))},${Math.max(5, Math.min(h - 5, d.y))})`;
  });
  this.text
    .attr("transform", function(d) {
      return `translate(${Math.max(5, Math.min(w - 5, d.x))},${Math.max(5, Math.min(h - 5, d.y))})`;
    })
    .attr("text-anchor", d => (d.x > w / 2 ? "start" : "end"));
};

CareAreaD3.prototype.cleanup = function() {
  this.update([]);
  this.force.stop();
};
