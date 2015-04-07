function map51f(o){
	this.o = o;
};
map51f.prototype.initialize = function() {
	var mapOptions = new MMapOptions();//������ͼ������
	mapOptions.zoom = 13;//Ҫ���صĵ�ͼ�����ż���
	mapOptions.center = new MLngLat(116.397428,39.90923);//Ҫ���صĵ�ͼ�����ĵ㾭γ������
	mapOptions.toolbar = DEFAULT;//���õ�ͼ��ʼ��������
	mapOptions.toolbarPos = new MPoint(5, 5); //���ù������ڵ�ͼ�ϵ���ʾλ��
	mapOptions.overviewMap = SHOW; //����ӥ�۵�ͼ��״̬��SHOW:��ʾ��HIDE:���أ�Ĭ�ϣ�
	mapOptions.scale = SHOW; //���õ�ͼ��ʼ��������״̬��SHOW:��ʾ��Ĭ�ϣ���HIDE:���ء�
	mapOptions.returnCoordType = COORD_TYPE_OFFSET;//������������
	mapOptions.zoomBox = true;//���������ź�˫���Ŵ�ʱ�Ƿ��к�򶯻�Ч����
	mapObj = new MMap(this.o, mapOptions); //��ͼ��ʼ��
	mapObj.setKeyboardEnabled(false);
};
map51f.prototype.setKeyboardEnabled = function(o) {
	mapObj.setKeyboardEnabled(o);
};
map51f.prototype.setCenter = function(x, y) {
	mapObj.setCenter(new MLngLat(x, y));
};
map51f.prototype.setCenterByCity = function(city) {
	var c = (city == "" || city == undefined) ? "010" : city;
	var maptools = new MMapTools(mapObj);
	maptools.setCenterByCity(c); 
};
map51f.prototype.getCenter = function() {
	return mapObj.getCenter();
};
map51f.prototype.getZoomLevel = function() {
	mapObj.getZoomLevel();
};
map51f.prototype.setZoomLevel = function(a) {
	var z = (a == "" || a == undefined) ? 13 : a;
	mapObj.setZoomLevel(z);//���õ�ͼzoom����Ϊ17
};
map51f.prototype.getSearch = function(data) {
	var condition = (data == "" || data == undefined) ? {} : data;
	var keyword = (condition.keyword == "" || condition.keyword == undefined) ? "" : condition.keyword;
	var city = (condition.city == "" || condition.city == undefined) ? "����" : condition.city;
	var type = (condition.type == "" || condition.type == undefined) ? "" : condition.type;
	var page = (condition.page == "" || condition.page == undefined) ? 1 : condition.page;
	var callBack = (condition.callBack == "" || condition.callBack == undefined) ? callback : condition.callBack;
	var maxPerPage = (condition.maxPerPage == "" || condition.maxPerPage == undefined) ? 10 : condition.maxPerPage;
	var MSearch = new MPoiSearch(); 
	var opt = new MPoiSearchOptions();
	opt.recordsPerPage = maxPerPage;//ÿҳ������������Ĭ��Ϊ10 
	opt.pageNum = page;//��ǰҳ���� 
	opt.dataType = "";//������𣬸ô�Ϊ�ִʲ�ѯ��ֻ��Ҫ�����ҵ�ؼ��ּ��� 
	opt.dataSources = DS_BASE_ENPOI;//����Դ������+��ҵ�ر����ݿ⣨Ĭ�ϣ�   
	MSearch.setCallbackFunction(callBack);
	MSearch.poiSearchByKeywords(keyword, city, opt);
};
map51f.prototype.getSearchAround = function(condition) {
	var x = (condition.x == "" || condition.x == undefined) ? "" : condition.x;
	var y = (condition.y == "" || condition.y == undefined) ? "" : condition.y;
	var keyword = (condition.keyword == "" || condition.keyword == undefined) ? "" : condition.keyword;
	var city = (condition.city == "" || condition.city == undefined) ? "����" : condition.city;
	var type = (condition.type == "" || condition.type == undefined) ? "" : condition.type;
	var callBack = (condition.callBack == "" || condition.callBack == undefined) ? callback : condition.callBack;
	var page = (condition.page == "" || condition.page == undefined) ? 1 : condition.page;
	var maxPerPage = (condition.maxPerPage == "" || condition.maxPerPage == undefined) ? 10 : condition.maxPerPage;
	var range = (condition.range == "" || condition.range == undefined) ? 1000 : condition.range;
	var poiXY = new MLngLat(x, y);//���ĵ�����
	var MSearch = new MPoiSearch();
    var opt = new MPoiSearchOptions();
    opt.recordsPerPage = maxPerPage;//ÿҳ������������Ĭ��Ϊ10
    opt.pageNum = page;//��ǰҳ��
    opt.dataType = type;//������𣬸ô�Ϊ�ִʲ�ѯ��ֻ��Ҫ�����ҵ�ؼ��ּ��� 
    opt.dataSources = DS_BASE_ENPOI;//����Դ������+��ҵ�ر����ݿ⣨Ĭ�ϣ� 
    opt.range = range;//��ѯ��Χ����λΪ�ף�Ĭ��ֵΪ3000 
    opt.naviFlag = 0;//�ܱ߲�ѯ���ؽ���Ƿ񰴵�����������,0������������������Ĭ�ϣ�1���������������� 
    MSearch.setCallbackFunction(callBack); 
    MSearch.poiSearchByCenPoi(poiXY, keyword, city, opt);
};
map51f.prototype.getBounds = function() {
	return mapObj.getLngLatBounds();//��ȡ��ͼ������Ұ���϶����Ǿ�γ������
};
map51f.prototype.setRegion2String = function(data) {
	return data.northEast.lngX + "," + data.northEast.latY + "," + data.southWest.lngX + "," + data.southWest.latY;
};
map51f.prototype.getSearchRegion = function(condition) {
	var keyword = (condition.keyword == "" || condition.keyword == undefined) ? "" : condition.keyword;
	//MOverlay.TYPE_POLYGON������Σ�MOverlay.TYPE_CIRCLE��Բ�Σ�MOverlay.TYPE_RECTANGLE������
	var type = (condition.type == "" || condition.type == undefined) ? MOverlay.TYPE_RECTANGLE : condition.type;
	var maxPerPage = (condition.maxPerPage == "" || condition.maxPerPage == undefined) ? 99999 : condition.maxPerPage;
	var page = (condition.page == "" || condition.page == undefined) ? 1 : condition.page;
	var region = (condition.region == "" || condition.region == undefined) ? this.setRegion2String(this.getBounds()) : condition.region;
	var callBack = (condition.callBack == "" || condition.callBack == undefined) ? callback : condition.callBack;
	var arr1 = region.split(","); 
    var regionArr = new Array(); 
    for(var i = 0 ;i<=arr1.length-2;){ 
        var mll =new MLngLat(arr1[i],arr1[i+1]); 
        regionArr.push(mll); 
        i=i+2; 
    } 
	var mlls = new MLngLats(regionArr);
	var MSearch = new MPoiSearch();
	var opt= new MPoiSearchOptions();
	opt.recordsPerPage = maxPerPage;//ÿҳ������������Ĭ��Ϊ10 
    opt.pageNum = page;//��ǰҳ���� 
    opt.dataType = "";//������𣬸ô�Ϊ�ִʲ�ѯ��ֻ��Ҫ�����ҵ�ؼ��ּ��� 
    opt.dataSources = DS_BASE_ENPOI;//����Դ������+��ҵ�ر����ݿ⣨Ĭ�ϣ�
	MSearch.setCallbackFunction(callBack);
	MSearch.poiSearchByRegion(type, mlls, keyword, opt);
};
map51f.prototype.setPoint = function(x, y, z) {
	var marker = new MMarker(new MLngLat(x, y));
	marker.id = "marker"+z;
	mapObj.addOverlay(marker);
};
map51f.prototype.setHtmlPoint = function(x, y, id, html, isCenter) {
	var id = (id == "" || id == undefined) ? 0 : id;
	var html = (html == "" || html == undefined) ? "" : html;
	var isCenter = (isCenter == "" || isCenter == undefined) ? false : isCenter;
	var opt = new MBoxOptions();   
	opt.content = html; 
	opt.boxAlign = BOTTOM_CENTER; 
	var box = new MBox(new MLngLat(x, y), opt); 
	box.id = "box"+id; 
	mapObj.addOverlay(box, isCenter);
};
map51f.prototype.addEventListener = function(action, clickfunction) {
	//���:MOUSE_CLICK 
    mapObj.addEventListener(mapObj, action, clickfunction);//����¼�����
};
map51f.prototype.setCtrlPanelState = function(a, b) {
	//ӥ��:OVERVIEW_CTRL(SHOW,HIDE,MINIMIZE) ������:TOOLBAR_CTRL(SHOW,HIDE) ������:SCALE_CTRL(SHOW,HIDE)
	mapObj.setCtrlPanelState(a, b);
};
map51f.prototype.setCtrlPanel = function(a) {
	var toolbarOpt = {};//��������������
    toolbarOpt.toolbarPos = new MPoint(5,5);//������λ�� 
    toolbarOpt.toolbar = a;//Ĭ��:DEFAULT С��:SMALL ����:MINI
    toolbarOpt.toolbarUrl = "";//������URL�������Զ��幤���� 
    mapObj.loadCtrlPanel(TOOLBAR_CTRL,toolbarOpt);//���������
};
map51f.prototype.setZoomIn = function() {
	mapObj.zoomIn();
};
map51f.prototype.setZoomOut = function() {
	mapObj.zoomOut();
};
map51f.prototype.clearMap = function() {
	mapObj.clearMap();
};
map51f.prototype.panTo = function(data) {
	var d = (data == "" || data == undefined) ? {} : data;
	var x = (d.x == "" || d.x == undefined) ? "116.397428" : d.x;
	var y = (d.y == "" || d.y == undefined) ? "39.90923" : d.y;
	mapObj.panTo(new MLngLat(x, y));
};
map51f.prototype.getBusSearch = function(data) {
	var d = (data == "" || data ==undefined) ? {} : data;
	if ( d.start_x == "" || d.start_x == undefined || d.start_y == "" || d.start_y == undefined ) { alert("������겻��Ϊ��"); return;}
	if ( d.end_x == "" || d.end_x == undefined || d.end_y == "" || d.end_y == undefined ) { alert("�յ����겻��Ϊ��"); return;}
	var city = (d.city == "" || d.city == undefined) ? "����" : d.city;
	var callBack = (d.callBack == "" || d.callBack == undefined) ? callback : d.callBack;
	var perpage = (d.maxPerPage == "" || d.maxPerPage == undefined) ? 1 : d.maxPerPage;
	var page = (d.page == "" || d.page == undefined) ? 1 : d.page;
	var startXY= new MLngLat(d.start_x, d.start_y); 
	var endXY = new MLngLat(d.end_x, d.end_y); 
	var MSearch = new MBusSearch(); 
	var opt = new MBusSearchOptions(); 
	//var MSearch = new MRouteSearch();
    //var opt =new MRouteSearchOptions();
	opt.per = 150;//������������ʾ�ڵ�ͼ�ϻ�����·���Ĺؼ���ĸ�����Ĭ��Ϊ150 
	opt.routeType = 0;//·���������0������ģʽ�������ܳ��������ͨ�Ϳ��ٹ�����· 
	MSearch.setCallbackFunction(callBack); 
	MSearch.busSearchByTwoPoi(startXY, endXY, city, opt);
	//MSearch.routeSearchByTwoPoi(startXY, endXY, opt); 
};
map51f.prototype.getDriveSearch = function(data) {
	var d = (data == "" || data ==undefined) ? {} : data;
	if ( d.start_x == "" || d.start_x == undefined || d.start_y == "" || d.start_y == undefined ) { alert("������겻��Ϊ��"); return;}
	if ( d.end_x == "" || d.end_x == undefined || d.end_y == "" || d.end_y == undefined ) { alert("�յ����겻��Ϊ��"); return;}
	var city = (d.city == "" || d.city == undefined) ? "����" : d.city;
	var callBack = (d.callBack == "" || d.callBack == undefined) ? callback : d.callBack;
	var perpage = (d.maxPerPage == "" || d.maxPerPage == undefined) ? 1 : d.maxPerPage;
	var page = (d.page == "" || d.page == undefined) ? 1 : d.page;
	var startXY= new MLngLat(d.start_x, d.start_y); 
	var endXY = new MLngLat(d.end_x, d.end_y);
	var MSearch = new MRouteSearch();
    var opt =new MRouteSearchOptions();
	opt.per = 150;//������������ʾ�ڵ�ͼ�ϻ�����·���Ĺؼ���ĸ�����Ĭ��Ϊ150 
	opt.routeType = 0;//·���������0������ģʽ�������ܳ��������ͨ�Ϳ��ٹ�����· 
	MSearch.setCallbackFunction(callBack); 
	MSearch.routeSearchByTwoPoi(startXY, endXY, opt); 
};
//JS�������ĳ��Ƚ�ȡ�ַ�������ʱ�����ڴˣ���������������
String.prototype.truncate = function (n) {
	var cut = 0;
	var str = '';
	if ( this.length < n ) return this;
	for ( var i=0; i<this.length; i++ ) {
		if ( this.charCodeAt(i) > 255 ) {
			str += this.substr(i,1);
			cut += 2;
		} else {
			str += this.substr(i,1);
			cut += 1;
		}
		if (cut >= n*2) {
			return str+'...';
		}
	}
	return str;
}