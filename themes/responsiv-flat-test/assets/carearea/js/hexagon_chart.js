"use strict";

var hexagon = function hexagon() {
    $(".careArea_container").append("<div class=\"cc_hexagon_charts\">\n\t<svg class=\"defs\">\n\t\t<defs>\n\t\t\t<clipPath id=\"hexagon-clip\">\n\t\t\t\t<path d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\" />\n\t\t\t</clipPath>\n\n\t\t\t<linearGradient id=\"hexagon-gradient1\" x1=\"50%\" y1=\"0%\" x2=\"50%\" y2=\"100%\">\n\t\t\t\t<stop offset=\"0%\" style=\"stop-color:#d8f8b0;\" />\n\t\t\t\t<stop offset=\"100%\" style=\"stop-color:#94e69d;\" />\n\t\t\t</linearGradient>\n\t\t\t<linearGradient id=\"hexagon-gradient2\" x1=\"50%\" y1=\"0%\" x2=\"50%\" y2=\"100%\">\n\t\t\t\t<stop offset=\"0%\" style=\"stop-color:#3cd1c5\" />\n\t\t\t\t<stop offset=\"100%\" style=\"stop-color:#1dc4b7\" />\n\t\t\t</linearGradient>\n\t\t\t<linearGradient id=\"hexagon-gradient3\" x1=\"50%\" y1=\"0%\" x2=\"50%\" y2=\"100%\">\n\t\t\t\t<stop offset=\"0%\" style=\"stop-color:#fad0c4\" />\n\t\t\t\t<stop offset=\"100%\" style=\"stop-color:#ffb5b5\" />\n\t\t\t</linearGradient>\n\t\t\t<linearGradient id=\"hexagon-gradient4\" x1=\"50%\" y1=\"0%\" x2=\"50%\" y2=\"100%\">\n\t\t\t\t<stop offset=\"0%\" style=\"stop-color:#9fb8f7;\" />\n\t\t\t\t<stop offset=\"100%\" style=\"stop-color:#6583e3\" />\n\t\t\t</linearGradient>\n\t\t\t<linearGradient id=\"hexagon-gradient5\" x1=\"50%\" y1=\"0%\" x2=\"50%\" y2=\"100%\">\n\t\t\t\t<stop offset=\"0%\" style=\"stop-color:#b1e8f5;\" />\n\t\t\t\t<stop offset=\"100%\" style=\"stop-color:#8fd7ec;\" />\n\t\t\t</linearGradient>\n\t\t\t<linearGradient id=\"hexagon-gradient6\" x1=\"50%\" y1=\"0%\" x2=\"50%\" y2=\"100%\">\n\t\t\t\t<stop offset=\"0%\" style=\"stop-color:#ffecd2\" />\n\t\t\t\t<stop offset=\"100%\" style=\"stop-color:#fcb69f\" />\n\t\t\t</linearGradient>\n\t\t\t<linearGradient id=\"hexagon-gradient7\" x1=\"50%\" y1=\"0%\" x2=\"50%\" y2=\"100%\">\n\t\t\t\t<stop offset=\"0%\" style=\"stop-color:#d3c1e8\" />\n\t\t\t\t<stop offset=\"100%\" style=\"stop-color:#b39bd4\" />\n\t\t\t</linearGradient>\n\t\t</defs>\n\t</svg>\n\n\t<div class=\"hex-grid\">\n\t\t<svg href=\"/services\" class=\"hexagon menu\" id=\"services\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" viewbox=\"0 0 173.20508075688772 200\"\n\t\t preserveAspectRatio=\"true\">\n\t\t\t<path fill=\"url(#hexagon-gradient1)\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\" />\n\t\t\t<g transform=\"translate(62,55)\">\n\t\t\t\t<path fill=\"#fff\" d=\"M33.9,15.3C32.4,6.3,29,0,25,0S17.5,6.3,16,15.3H33.9z M15.3,25c0,2.2,0.1,4.4,0.3,6.5h18.7c0.2-2.1,0.3-4.2,0.3-6.5\n\t\t\t\ts-0.1-4.4-0.3-6.5H15.6C15.4,20.6,15.3,22.8,15.3,25z M48,15.3C45.1,8.5,39.3,3.2,32.1,1c2.5,3.4,4.2,8.5,5,14.3H48z M17.8,1\n\t\t\t\tc-7.2,2.1-13,7.4-15.9,14.3h10.9C13.7,9.6,15.4,4.5,17.8,1L17.8,1z M49.1,18.5H37.5c0.2,2.1,0.3,4.3,0.3,6.5s-0.1,4.3-0.3,6.5h11.6\n\t\t\t\tc0.6-2.1,0.9-4.2,0.9-6.5S49.6,20.6,49.1,18.5L49.1,18.5z M12,25c0-2.2,0.1-4.3,0.3-6.5H0.8C0.3,20.6,0,22.8,0,25s0.3,4.4,0.9,6.5\n\t\t\t\th11.6C12.2,29.3,12,27.2,12,25z M16,34.7c1.5,9,4.9,15.3,8.9,15.3s7.5-6.3,8.9-15.3H16z M32.1,49c7.2-2.1,13-7.4,15.9-14.3H37.1\n\t\t\t\tC36.2,40.4,34.6,45.5,32.1,49z M1.9,34.7c2.9,6.8,8.7,12.1,15.9,14.3c-2.5-3.4-4.2-8.5-5-14.3C12.8,34.7,1.9,34.7,1.9,34.7z\" />\n\t\t\t</g>\n\t\t\t<text text-anchor=\"middle\" x=\"87\" y=\"135\" font-size=\"16\">\u570B\u969B\u8996\u91CE\u8207\u7D93\u9A57</text>\n\t\t\t<g cursor=\"pointer\">\n\t\t\t\t<path fill=\"transparent\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\"\n\t\t\t\t onClick=\"categoryClick('\u570B\u969B\u8996\u91CE\u8207\u7D93\u9A57')\" />\n\t\t\t</g>\n\t\t</svg>\n\n\t\t<svg href=\"/story\" class=\"hexagon menu\" id=\"story\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" viewbox=\"0 0 173.20508075688772 200\"\n\t\t preserveAspectRatio=\"true\">\n\t\t\t<path fill=\"url(#hexagon-gradient2)\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\" />\n\t\t\t<g transform=\"translate(62,55)\">\n\t\t\t\t<path fill=\"#fff\" d=\"M48.8,32.5h-1.2v-8.4c0-1-0.4-1.9-1.1-2.6l-7.8-7.8c-0.7-0.7-1.7-1.1-2.6-1.1h-3.4V8.8c0-2.1-1.7-3.8-3.8-3.8h-25\n\t\t\t\tC1.7,5,0,6.7,0,8.8v25c0,2.1,1.7,3.8,3.8,3.8H5c0,4.1,3.4,7.5,7.5,7.5s7.5-3.4,7.5-7.5h10c0,4.1,3.4,7.5,7.5,7.5s7.5-3.4,7.5-7.5\n\t\t\t\th3.8c0.7,0,1.2-0.6,1.2-1.2v-2.5C50,33.1,49.4,32.5,48.8,32.5z M12.5,41.2c-2.1,0-3.8-1.7-3.8-3.8s1.7-3.8,3.8-3.8s3.8,1.7,3.8,3.8\n\t\t\t\tS14.6,41.2,12.5,41.2z M23.8,21.9c0,0.3-0.3,0.6-0.6,0.6h-4.4v4.4c0,0.3-0.3,0.6-0.6,0.6h-3.8c-0.3,0-0.6-0.3-0.6-0.6v-4.4H9.4\n\t\t\t\tc-0.3,0-0.6-0.3-0.6-0.6v-3.8c0-0.3,0.3-0.6,0.6-0.6h4.4v-4.4c0-0.3,0.3-0.6,0.6-0.6h3.8c0.3,0,0.6,0.3,0.6,0.6v4.4h4.4\n\t\t\t\tc0.3,0,0.6,0.3,0.6,0.6V21.9z M37.5,41.2c-2.1,0-3.8-1.7-3.8-3.8s1.7-3.8,3.8-3.8s3.8,1.7,3.8,3.8S39.6,41.2,37.5,41.2z M43.8,25\n\t\t\t\tH32.5v-8.8h3.4l7.8,7.8V25z\" />\n\t\t\t</g>\n\t\t\t<text text-anchor=\"middle\" x=\"87\" y=\"135\" font-size=\"16\">\u5065\u5EB7</text>\n\t\t\t<g cursor=\"pointer\">\n\t\t\t\t<path fill=\"transparent\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\"\n\t\t\t\t onClick=\"categoryClick('\u5065\u5EB7')\" />\n\t\t\t</g>\n\t\t</svg>\n\n\t\t<svg href=\"/processes\" class=\"hexagon menu\" id=\"processes\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"\n\t\t viewbox=\"0 0 173.20508075688772 200\" preserveAspectRatio=\"true\">\n\t\t\t<path fill=\"url(#hexagon-gradient3)\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\" />\n\t\t\t<g transform=\"translate(62,55)\">\n\t\t\t\t<path fill=\"#fff\" d=\"M7.5,22.5c2.8,0,5-2.2,5-5s-2.2-5-5-5s-5,2.2-5,5S4.7,22.5,7.5,22.5z M42.5,22.5c2.8,0,5-2.2,5-5s-2.2-5-5-5s-5,2.2-5,5\n\t\t\t\tS39.7,22.5,42.5,22.5z M45,25h-5c-1.4,0-2.6,0.6-3.5,1.5c3.1,1.7,5.4,4.8,5.9,8.5h5.2c1.4,0,2.5-1.1,2.5-2.5V30\n\t\t\t\tC50,27.2,47.8,25,45,25z M25,25c4.8,0,8.8-3.9,8.8-8.8S29.8,7.5,25,7.5s-8.8,3.9-8.8,8.8S20.2,25,25,25z M31,27.5h-0.6\n\t\t\t\tc-1.6,0.8-3.4,1.2-5.4,1.2s-3.7-0.5-5.4-1.2H19c-5,0-9,4-9,9v2.2c0,2.1,1.7,3.8,3.8,3.8h22.5c2.1,0,3.8-1.7,3.8-3.8v-2.2\n\t\t\t\tC40,31.5,36,27.5,31,27.5z M13.5,26.5C12.6,25.6,11.4,25,10,25H5c-2.8,0-5,2.2-5,5v2.5C0,33.9,1.1,35,2.5,35h5.1\n\t\t\t\tC8.1,31.3,10.4,28.2,13.5,26.5L13.5,26.5z\" />\n\t\t\t</g>\n\t\t\t<text text-anchor=\"middle\" x=\"87\" y=\"135\" font-size=\"16\">\u5BB6\u5EAD</text>\n\t\t\t<g cursor=\"pointer\">\n\t\t\t\t<path fill=\"transparent\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\"\n\t\t\t\t onClick=\"categoryClick('\u5BB6\u5EAD')\" />\n\t\t\t</g>\n\t\t</svg>\n\t\t<svg class=\"hexagon menu no-nav\" id=\"partners\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" viewbox=\"0 0 173.20508075688772 200\"\n\t\t preserveAspectRatio=\"true\">\n\t\t\t<path fill=\"url(#hexagon-gradient4)\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\" />\n\t\t\t<g transform=\"translate(62,55)\">\n\t\t\t\t<path fill=\"#fff\" d=\"M34.3,41.4L26.6,49c-0.9,0.9-2.4,0.9-3.3,0l-7.6-7.6c-1.5-1.5-0.4-3.9,1.6-3.9h4.9l0-9.7h-9.7v4.9c0,2.1-2.5,3.1-3.9,1.6\n\t\t\t\tL1,26.6c-0.9-0.9-0.9-2.4,0-3.3l7.6-7.6c1.5-1.5,3.9-0.4,3.9,1.6v4.9h9.7v-9.7h-4.9c-2.1,0-3.1-2.5-1.6-3.9L23.4,1\n\t\t\t\tc0.9-0.9,2.4-0.9,3.3,0l7.6,7.6c1.5,1.5,0.4,3.9-1.6,3.9h-4.9v9.7h9.7v-4.9c0-2.1,2.5-3.1,3.9-1.6l7.6,7.6c0.9,0.9,0.9,2.4,0,3.3\n\t\t\t\tl-7.6,7.6c-1.5,1.5-3.9,0.4-3.9-1.6v-4.9h-9.7v9.7h4.9C34.7,37.4,35.7,39.9,34.3,41.4L34.3,41.4z\" />\n\t\t\t</g>\n\t\t\t<text text-anchor=\"middle\" x=\"87\" y=\"135\" font-size=\"16\">\u8DE8\u754C\u91CD\u9EDE\u8B70\u984C</text>\n\t\t\t<g cursor=\"pointer\">\n\t\t\t\t<path fill=\"transparent\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\"\n\t\t\t\t onClick=\"categoryClick('\u8DE8\u754C\u91CD\u9EDE\u8B70\u984C')\" />\n\t\t\t</g>\n\t\t</svg>\n\t\t<svg href=\"/blog\" class=\"hexagon menu\" id=\"blog\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" viewbox=\"0 0 173.20508075688772 200\"\n\t\t preserveAspectRatio=\"true\">\n\t\t\t<path fill=\"url(#hexagon-gradient5)\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\" />\n\t\t\t<g transform=\"translate(62,55)\">\n\t\t\t\t<path fill=\"#fff\" d=\"M48.6,22.2h-2.6c-0.8-1.7-1.9-3.3-3.2-4.6l1.6-6.6h-2.8c-2.6,0-4.8,1.2-6.3,3c-0.7-0.1-1.3-0.2-2-0.2H22.2\n\t\t\t\tc-6.7,0-12.3,4.8-13.6,11.1H4.9c-1.3,0-2.3-1.2-2-2.5C3,21.5,4,20.8,5,20.8H5c0.3,0,0.5-0.2,0.5-0.5v-1.7c0-0.3-0.2-0.5-0.5-0.5\n\t\t\t\tc-2.5,0-4.7,1.8-5,4.2c-0.4,3,1.9,5.5,4.8,5.5h3.5c0,4.5,2.2,8.5,5.6,11.1v7c0,0.8,0.6,1.4,1.4,1.4h5.6c0.8,0,1.4-0.6,1.4-1.4v-4.2\n\t\t\t\th11.1v4.2c0,0.8,0.6,1.4,1.4,1.4h5.6c0.8,0,1.4-0.6,1.4-1.4v-7c1-0.8,1.9-1.7,2.7-2.7h4.2c0.8,0,1.4-0.6,1.4-1.4V23.6\n\t\t\t\tC50,22.8,49.4,22.2,48.6,22.2z M37.5,27.8c-0.8,0-1.4-0.6-1.4-1.4s0.6-1.4,1.4-1.4c0.8,0,1.4,0.6,1.4,1.4S38.3,27.8,37.5,27.8z\n\t\t\t\tM22.2,11.1h11.1c0.5,0,0.9,0,1.4,0.1c0,0,0,0,0-0.1c0-4.6-3.7-8.3-8.3-8.3s-8.3,3.7-8.3,8.3c0,0.2,0,0.4,0.1,0.5\n\t\t\t\tC19.4,11.3,20.8,11.1,22.2,11.1z\" />\n\t\t\t</g>\n\t\t\t<text text-anchor=\"middle\" x=\"87\" y=\"135\" font-size=\"16\">\u7D93\u6FDF\u6A5F\u6703</text>\n\t\t\t<g cursor=\"pointer\">\n\t\t\t\t<path fill=\"transparent\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\"\n\t\t\t\t onClick=\"categoryClick('\u7D93\u6FDF\u6A5F\u6703')\" />\n\t\t\t</g>\n\t\t</svg>\n\t\t<svg class=\"hexagon menu no-nav\" id=\"join\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" viewbox=\"0 0 173.20508075688772 200\"\n\t\t preserveAspectRatio=\"true\">\n\t\t\t<path fill=\"url(#hexagon-gradient6)\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\" />\n\t\t\t<g transform=\"translate(62,55)\">\n\t\t\t\t<path fill=\"#fff\" d=\"M46.9,35.2V2.3c0-1.3-1-2.3-2.3-2.3h-32C7.3,0,3.1,4.2,3.1,9.4v31.2c0,5.2,4.2,9.4,9.4,9.4h32c1.3,0,2.3-1,2.3-2.3v-1.6\n\t\t\t\tc0-0.7-0.3-1.4-0.9-1.8c-0.4-1.5-0.4-5.8,0-7.3C46.5,36.6,46.9,35.9,46.9,35.2L46.9,35.2z M15.6,13.1c0-0.3,0.3-0.6,0.6-0.6h20.7\n\t\t\t\tc0.3,0,0.6,0.3,0.6,0.6v2c0,0.3-0.3,0.6-0.6,0.6H16.2c-0.3,0-0.6-0.3-0.6-0.6V13.1z M15.6,19.3c0-0.3,0.3-0.6,0.6-0.6h20.7\n\t\t\t\tc0.3,0,0.6,0.3,0.6,0.6v2c0,0.3-0.3,0.6-0.6,0.6H16.2c-0.3,0-0.6-0.3-0.6-0.6V19.3z M40.4,43.8H12.5c-1.7,0-3.1-1.4-3.1-3.1\n\t\t\t\tc0-1.7,1.4-3.1,3.1-3.1h27.9C40.2,39.2,40.2,42.1,40.4,43.8z\" />\n\t\t\t</g>\n\t\t\t<text text-anchor=\"middle\" x=\"87\" y=\"135\" font-size=\"16\">\u6559\u80B2</text>\n\t\t\t<g cursor=\"pointer\">\n\t\t\t\t<path fill=\"transparent\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\"\n\t\t\t\t onClick=\"categoryClick('\u6559\u80B2')\" />\n\t\t\t</g>\n\t\t</svg>\n\t\t<svg class=\"hexagon menu no-nav\" id=\"join\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" viewbox=\"0 0 173.20508075688772 200\"\n\t\t preserveAspectRatio=\"true\">\n\t\t\t<path fill=\"url(#hexagon-gradient7)\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\" />\n\t\t\t<g transform=\"translate(62,55)\">\n\t\t\t\t<path fill=\"#fff\" d=\"M36.1,19.4c0-7.7-8.1-13.9-18.1-13.9S0,11.8,0,19.4c0,3,1.2,5.7,3.3,8c-1.2,2.6-3.1,4.7-3.1,4.7c-0.2,0.2-0.2,0.5-0.1,0.8\n\t\t\t\ts0.4,0.4,0.6,0.4c3.2,0,5.8-1.1,7.7-2.2c2.8,1.4,6.1,2.2,9.7,2.2C28,33.3,36.1,27.1,36.1,19.4z M46.7,38.5c2.1-2.3,3.3-5,3.3-8\n\t\t\t\tc0-5.8-4.6-10.8-11.2-12.9c0.1,0.6,0.1,1.2,0.1,1.7c0,9.2-9.3,16.7-20.8,16.7c-0.9,0-1.8-0.1-2.8-0.2c2.7,5,9.2,8.5,16.6,8.5\n\t\t\t\tc3.6,0,6.9-0.8,9.7-2.2c1.9,1.1,4.5,2.2,7.7,2.2c0.3,0,0.5-0.2,0.6-0.4c0.1-0.3,0.1-0.5-0.1-0.8C49.8,43.2,47.9,41.2,46.7,38.5z\" />\n\t\t\t</g>\n\t\t\t<text text-anchor=\"middle\" x=\"87\" y=\"135\" font-size=\"16\">\u516C\u6C11\u8207\u793E\u6703\u53C3\u8207</text>\n\t\t\t<g cursor=\"pointer\">\n\t\t\t\t<path fill=\"transparent\" d=\"M75.34421012924616 6.499999999999999Q86.60254037844386 0 97.86087062764156 6.499999999999999L161.94675050769 43.5Q173.20508075688772 50 173.20508075688772 63L173.20508075688772 137Q173.20508075688772 150 161.94675050769 156.5L97.86087062764156 193.5Q86.60254037844386 200 75.34421012924616 193.5L11.258330249197703 156.5Q0 150 0 137L0 63Q0 50 11.258330249197703 43.5Z\"\n\t\t\t\t onClick=\"categoryClick('\u516C\u6C11\u8207\u793E\u6703\u53C3\u8207')\" />\n\t\t\t</g>\n\t\t</svg>\n\t</div>\n\n</div>");
};