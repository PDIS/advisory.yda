const render_cc_blocksInfo = function() {
  let cc_blocksInfo = $.map(countingCaseInfoDetail, detail => {
    return `<div class="cc_block">
					<div class="cc_block_header">
						<div class="cc_block_header_num">${detail.num}</div>
						<div class="cc_block_header_info">
							<h5>${detail.name}</h5>
							<p>${detail.time}</p>
						</div>
					</div>
					<div class="cc_block_info">
						<p>${detail.info}</p>
					</div>

				</div>`;
  });

  $(".cc_blocks").append(cc_blocksInfo);
};
