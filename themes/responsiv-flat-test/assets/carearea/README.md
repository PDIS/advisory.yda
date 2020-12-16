# 青發署_健康網

## 檔案結構

```
├── d3 //d3's resources
├── data
 ├── color.js // 我們關心的領域_7個類別個別的顏色組
 ├── countingCaseInfo.js // 盤點案內文資訊
 └── YouthDevPJs.js // 我們關心的領域_主體內文資訊
├── images
├── js
 ├── careArea.js // 我們關心的領域_清單邏輯與渲染
 ├── countingCase.js // 盤點案_渲染
 ├── d3_CareAreaD3.js // d3 chart_調整與設定
 ├── d3_chart.js // d3 chart_處理成 chart 需要的資料
 ├── d3_dataConverter.js //d3 chart_chart 本身 data 轉換
 ├── hexagon_chart.js // 我們關心的領域_六角形選染與邏輯
 └── render_body.js // 我們關心的領域 與 盤點案 頁面轉換邏輯與渲染
├── style
 ├── countingCase.css // 盤點案 style
 └── index.css // 我們關心的領域 style
├── index.html
└── README.md
```

## 符號表示
- `// [N]` 表示註解


## 如何引用檔案
詳細程式碼應用請見 `index.html`

- 點開 index.html
- 加入 css
	- 引用 fontawesome's cdn css
	- `index.css` 導入 我們關心的領域's css
	- `countingCase.css` 導入 盤點案's css

```
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
		integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="./styles/index.css">
<link rel="stylesheet" href="./styles/countingCase.css">
```


- 加入 javascript cdn
	- 引用 jQuery's cdn js
	- 導入 d3 js
```
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="./d3/d3.js"></script>
<script type="text/javascript" src="./d3/d3.geom.js"></script>
<script type="text/javascript" src="./d3/d3.layout.js"></script>
<script type="text/javascript" src="./js/d3_CareAreaD3.js"></script>
<script type="text/javascript" src="./js/d3_dataConverter.js"></script>
```


- 加入靜態 data 檔案
	- `color.js` 導入 我們關心的領域_7個類別個別的顏色組
	- `countingCaseInfo.js` 導入 盤點案內文資訊
	- `YouthDevPJs.js` 導入 我們關心的領域_主體內文資訊

```
<script src="./data/countingCaseInfo.js"></script>
<script src="./data/YouthDevPJs.js"></script>
<script src="./data/color.js"></script>
```

- 加入 js 邏輯
	- `careArea.js` 導入 我們關心的領域_清單邏輯與渲染
	- `countingCase.js` 導入 盤點案_渲染
	- `d3_CareAreaD3.js` 導入 d3 chart_調整與設定
	- `d3_chart.js` 導入 d3 chart_處理成 chart 需要的資料
	- `d3_dataConverter.js` 導入 d3 chart_chart 本身 data 轉換
	- `hexagon_chart.js` 導入 我們關心的領域_六角形選染與邏輯
	- `render_body.js` 導入 我們關心的領域 與 盤點案 頁面轉換邏輯與渲染
```
<script src="./js/render_bodyInner.js"></script>
<script src="./js/countingCase.js"></script>

<script src="./js/hexagon_chart.js"></script>
<script src="./js/d3_chart.js"></script>
<script src="./js/careArea.js"></script>
```

- 於 html 內加入 id 為 `ydp_index` 的 div
```
<div id="ydp_index"></div>
```

- 觸發 js 渲染 function `render_bodyInner()`
```
render_bodyInner("careArea")
```