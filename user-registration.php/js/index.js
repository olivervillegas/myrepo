import { ZoomMtg } from ‘@zoomus/websdk’
// For CDN version default
function()
{
  ZoomMtg.setZoomJSLib('https://dmogdx0jrul3u.cloudfront.net/1.8.5/lib', '/av');
  ZoomMtg.preLoadWasm();
  ZoomMtg.prepareJssdk();
}
