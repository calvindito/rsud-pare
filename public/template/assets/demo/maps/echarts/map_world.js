/* ------------------------------------------------------------------------------
 *
 *  # Echarts - EU map with scatter example
 *
 *  Demo JS code for EU map with scatter chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsMapWorld = function() {


    //
    // Setup module components
    //

    // Basic bar chart
    var _mapWorldExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var map_world_element = document.getElementById('map_world');

        // Chart configuration
        if (map_world_element) {

            // Initialize chart
            var map_world = echarts.init(map_world_element, null, { renderer: 'svg' });


            //
            // Chart config
            //

            // Country coordinates helper
            var latlong = {};
            latlong.AD = {'latitude':42.5, 'longitude':1.5};
            latlong.AE = {'latitude':24, 'longitude':54};
            latlong.AF = {'latitude':33, 'longitude':65};
            latlong.AG = {'latitude':17.05, 'longitude':-61.8};
            latlong.AI = {'latitude':18.25, 'longitude':-63.1667};
            latlong.AL = {'latitude':41, 'longitude':20};
            latlong.AM = {'latitude':40, 'longitude':45};
            latlong.AN = {'latitude':12.25, 'longitude':-68.75};
            latlong.AO = {'latitude':-12.5, 'longitude':18.5};
            latlong.AP = {'latitude':35, 'longitude':105};
            latlong.AQ = {'latitude':-90, 'longitude':0};
            latlong.AR = {'latitude':-34, 'longitude':-64};
            latlong.AS = {'latitude':-14.3333, 'longitude':-170};
            latlong.AT = {'latitude':47.3333, 'longitude':13.3333};
            latlong.AU = {'latitude':-27, 'longitude':133};
            latlong.AW = {'latitude':12.5, 'longitude':-69.9667};
            latlong.AZ = {'latitude':40.5, 'longitude':47.5};
            latlong.BA = {'latitude':44, 'longitude':18};
            latlong.BB = {'latitude':13.1667, 'longitude':-59.5333};
            latlong.BD = {'latitude':24, 'longitude':90};
            latlong.BE = {'latitude':50.8333, 'longitude':4};
            latlong.BF = {'latitude':13, 'longitude':-2};
            latlong.BG = {'latitude':43, 'longitude':25};
            latlong.BH = {'latitude':26, 'longitude':50.55};
            latlong.BI = {'latitude':-3.5, 'longitude':30};
            latlong.BJ = {'latitude':9.5, 'longitude':2.25};
            latlong.BM = {'latitude':32.3333, 'longitude':-64.75};
            latlong.BN = {'latitude':4.5, 'longitude':114.6667};
            latlong.BO = {'latitude':-17, 'longitude':-65};
            latlong.BR = {'latitude':-10, 'longitude':-55};
            latlong.BS = {'latitude':24.25, 'longitude':-76};
            latlong.BT = {'latitude':27.5, 'longitude':90.5};
            latlong.BV = {'latitude':-54.4333, 'longitude':3.4};
            latlong.BW = {'latitude':-22, 'longitude':24};
            latlong.BY = {'latitude':53, 'longitude':28};
            latlong.BZ = {'latitude':17.25, 'longitude':-88.75};
            latlong.CA = {'latitude':54, 'longitude':-100};
            latlong.CC = {'latitude':-12.5, 'longitude':96.8333};
            latlong.CD = {'latitude':0, 'longitude':25};
            latlong.CF = {'latitude':7, 'longitude':21};
            latlong.CG = {'latitude':-1, 'longitude':15};
            latlong.CH = {'latitude':47, 'longitude':8};
            latlong.CI = {'latitude':8, 'longitude':-5};
            latlong.CK = {'latitude':-21.2333, 'longitude':-159.7667};
            latlong.CL = {'latitude':-30, 'longitude':-71};
            latlong.CM = {'latitude':6, 'longitude':12};
            latlong.CN = {'latitude':35, 'longitude':105};
            latlong.CO = {'latitude':4, 'longitude':-72};
            latlong.CR = {'latitude':10, 'longitude':-84};
            latlong.CU = {'latitude':21.5, 'longitude':-80};
            latlong.CV = {'latitude':16, 'longitude':-24};
            latlong.CX = {'latitude':-10.5, 'longitude':105.6667};
            latlong.CY = {'latitude':35, 'longitude':33};
            latlong.CZ = {'latitude':49.75, 'longitude':15.5};
            latlong.DE = {'latitude':51, 'longitude':9};
            latlong.DJ = {'latitude':11.5, 'longitude':43};
            latlong.DK = {'latitude':56, 'longitude':10};
            latlong.DM = {'latitude':15.4167, 'longitude':-61.3333};
            latlong.DO = {'latitude':19, 'longitude':-70.6667};
            latlong.DZ = {'latitude':28, 'longitude':3};
            latlong.EC = {'latitude':-2, 'longitude':-77.5};
            latlong.EE = {'latitude':59, 'longitude':26};
            latlong.EG = {'latitude':27, 'longitude':30};
            latlong.EH = {'latitude':24.5, 'longitude':-13};
            latlong.ER = {'latitude':15, 'longitude':39};
            latlong.ES = {'latitude':40, 'longitude':-4};
            latlong.ET = {'latitude':8, 'longitude':38};
            latlong.EU = {'latitude':47, 'longitude':8};
            latlong.FI = {'latitude':62, 'longitude':26};
            latlong.FJ = {'latitude':-18, 'longitude':175};
            latlong.FK = {'latitude':-51.75, 'longitude':-59};
            latlong.FM = {'latitude':6.9167, 'longitude':158.25};
            latlong.FO = {'latitude':62, 'longitude':-7};
            latlong.FR = {'latitude':46, 'longitude':2};
            latlong.GA = {'latitude':-1, 'longitude':11.75};
            latlong.GB = {'latitude':54, 'longitude':-2};
            latlong.GD = {'latitude':12.1167, 'longitude':-61.6667};
            latlong.GE = {'latitude':42, 'longitude':43.5};
            latlong.GF = {'latitude':4, 'longitude':-53};
            latlong.GH = {'latitude':8, 'longitude':-2};
            latlong.GI = {'latitude':36.1833, 'longitude':-5.3667};
            latlong.GL = {'latitude':72, 'longitude':-40};
            latlong.GM = {'latitude':13.4667, 'longitude':-16.5667};
            latlong.GN = {'latitude':11, 'longitude':-10};
            latlong.GP = {'latitude':16.25, 'longitude':-61.5833};
            latlong.GQ = {'latitude':2, 'longitude':10};
            latlong.GR = {'latitude':39, 'longitude':22};
            latlong.GS = {'latitude':-54.5, 'longitude':-37};
            latlong.GT = {'latitude':15.5, 'longitude':-90.25};
            latlong.GU = {'latitude':13.4667, 'longitude':144.7833};
            latlong.GW = {'latitude':12, 'longitude':-15};
            latlong.GY = {'latitude':5, 'longitude':-59};
            latlong.HK = {'latitude':22.25, 'longitude':114.1667};
            latlong.HM = {'latitude':-53.1, 'longitude':72.5167};
            latlong.HN = {'latitude':15, 'longitude':-86.5};
            latlong.HR = {'latitude':45.1667, 'longitude':15.5};
            latlong.HT = {'latitude':19, 'longitude':-72.4167};
            latlong.HU = {'latitude':47, 'longitude':20};
            latlong.ID = {'latitude':-5, 'longitude':120};
            latlong.IE = {'latitude':53, 'longitude':-8};
            latlong.IL = {'latitude':31.5, 'longitude':34.75};
            latlong.IN = {'latitude':20, 'longitude':77};
            latlong.IO = {'latitude':-6, 'longitude':71.5};
            latlong.IQ = {'latitude':33, 'longitude':44};
            latlong.IR = {'latitude':32, 'longitude':53};
            latlong.IS = {'latitude':65, 'longitude':-18};
            latlong.IT = {'latitude':42.8333, 'longitude':12.8333};
            latlong.JM = {'latitude':18.25, 'longitude':-77.5};
            latlong.JO = {'latitude':31, 'longitude':36};
            latlong.JP = {'latitude':36, 'longitude':138};
            latlong.KE = {'latitude':1, 'longitude':38};
            latlong.KG = {'latitude':41, 'longitude':75};
            latlong.KH = {'latitude':13, 'longitude':105};
            latlong.KI = {'latitude':1.4167, 'longitude':173};
            latlong.KM = {'latitude':-12.1667, 'longitude':44.25};
            latlong.KN = {'latitude':17.3333, 'longitude':-62.75};
            latlong.KP = {'latitude':40, 'longitude':127};
            latlong.KR = {'latitude':37, 'longitude':127.5};
            latlong.KW = {'latitude':29.3375, 'longitude':47.6581};
            latlong.KY = {'latitude':19.5, 'longitude':-80.5};
            latlong.KZ = {'latitude':48, 'longitude':68};
            latlong.LA = {'latitude':18, 'longitude':105};
            latlong.LB = {'latitude':33.8333, 'longitude':35.8333};
            latlong.LC = {'latitude':13.8833, 'longitude':-61.1333};
            latlong.LI = {'latitude':47.1667, 'longitude':9.5333};
            latlong.LK = {'latitude':7, 'longitude':81};
            latlong.LR = {'latitude':6.5, 'longitude':-9.5};
            latlong.LS = {'latitude':-29.5, 'longitude':28.5};
            latlong.LT = {'latitude':55, 'longitude':24};
            latlong.LU = {'latitude':49.75, 'longitude':6};
            latlong.LV = {'latitude':57, 'longitude':25};
            latlong.LY = {'latitude':25, 'longitude':17};
            latlong.MA = {'latitude':32, 'longitude':-5};
            latlong.MC = {'latitude':43.7333, 'longitude':7.4};
            latlong.MD = {'latitude':47, 'longitude':29};
            latlong.ME = {'latitude':42.5, 'longitude':19.4};
            latlong.MG = {'latitude':-20, 'longitude':47};
            latlong.MH = {'latitude':9, 'longitude':168};
            latlong.MK = {'latitude':41.8333, 'longitude':22};
            latlong.ML = {'latitude':17, 'longitude':-4};
            latlong.MM = {'latitude':22, 'longitude':98};
            latlong.MN = {'latitude':46, 'longitude':105};
            latlong.MO = {'latitude':22.1667, 'longitude':113.55};
            latlong.MP = {'latitude':15.2, 'longitude':145.75};
            latlong.MQ = {'latitude':14.6667, 'longitude':-61};
            latlong.MR = {'latitude':20, 'longitude':-12};
            latlong.MS = {'latitude':16.75, 'longitude':-62.2};
            latlong.MT = {'latitude':35.8333, 'longitude':14.5833};
            latlong.MU = {'latitude':-20.2833, 'longitude':57.55};
            latlong.MV = {'latitude':3.25, 'longitude':73};
            latlong.MW = {'latitude':-13.5, 'longitude':34};
            latlong.MX = {'latitude':23, 'longitude':-102};
            latlong.MY = {'latitude':2.5, 'longitude':112.5};
            latlong.MZ = {'latitude':-18.25, 'longitude':35};
            latlong.NA = {'latitude':-22, 'longitude':17};
            latlong.NC = {'latitude':-21.5, 'longitude':165.5};
            latlong.NE = {'latitude':16, 'longitude':8};
            latlong.NF = {'latitude':-29.0333, 'longitude':167.95};
            latlong.NG = {'latitude':10, 'longitude':8};
            latlong.NI = {'latitude':13, 'longitude':-85};
            latlong.NL = {'latitude':52.5, 'longitude':5.75};
            latlong.NO = {'latitude':62, 'longitude':10};
            latlong.NP = {'latitude':28, 'longitude':84};
            latlong.NR = {'latitude':-0.5333, 'longitude':166.9167};
            latlong.NU = {'latitude':-19.0333, 'longitude':-169.8667};
            latlong.NZ = {'latitude':-41, 'longitude':174};
            latlong.OM = {'latitude':21, 'longitude':57};
            latlong.PA = {'latitude':9, 'longitude':-80};
            latlong.PE = {'latitude':-10, 'longitude':-76};
            latlong.PF = {'latitude':-15, 'longitude':-140};
            latlong.PG = {'latitude':-6, 'longitude':147};
            latlong.PH = {'latitude':13, 'longitude':122};
            latlong.PK = {'latitude':30, 'longitude':70};
            latlong.PL = {'latitude':52, 'longitude':20};
            latlong.PM = {'latitude':46.8333, 'longitude':-56.3333};
            latlong.PR = {'latitude':18.25, 'longitude':-66.5};
            latlong.PS = {'latitude':32, 'longitude':35.25};
            latlong.PT = {'latitude':39.5, 'longitude':-8};
            latlong.PW = {'latitude':7.5, 'longitude':134.5};
            latlong.PY = {'latitude':-23, 'longitude':-58};
            latlong.QA = {'latitude':25.5, 'longitude':51.25};
            latlong.RE = {'latitude':-21.1, 'longitude':55.6};
            latlong.RO = {'latitude':46, 'longitude':25};
            latlong.RS = {'latitude':44, 'longitude':21};
            latlong.RU = {'latitude':60, 'longitude':100};
            latlong.RW = {'latitude':-2, 'longitude':30};
            latlong.SA = {'latitude':25, 'longitude':45};
            latlong.SB = {'latitude':-8, 'longitude':159};
            latlong.SC = {'latitude':-4.5833, 'longitude':55.6667};
            latlong.SD = {'latitude':15, 'longitude':30};
            latlong.SE = {'latitude':62, 'longitude':15};
            latlong.SG = {'latitude':1.3667, 'longitude':103.8};
            latlong.SH = {'latitude':-15.9333, 'longitude':-5.7};
            latlong.SI = {'latitude':46, 'longitude':15};
            latlong.SJ = {'latitude':78, 'longitude':20};
            latlong.SK = {'latitude':48.6667, 'longitude':19.5};
            latlong.SL = {'latitude':8.5, 'longitude':-11.5};
            latlong.SM = {'latitude':43.7667, 'longitude':12.4167};
            latlong.SN = {'latitude':14, 'longitude':-14};
            latlong.SO = {'latitude':10, 'longitude':49};
            latlong.SR = {'latitude':4, 'longitude':-56};
            latlong.ST = {'latitude':1, 'longitude':7};
            latlong.SV = {'latitude':13.8333, 'longitude':-88.9167};
            latlong.SY = {'latitude':35, 'longitude':38};
            latlong.SZ = {'latitude':-26.5, 'longitude':31.5};
            latlong.TC = {'latitude':21.75, 'longitude':-71.5833};
            latlong.TD = {'latitude':15, 'longitude':19};
            latlong.TF = {'latitude':-43, 'longitude':67};
            latlong.TG = {'latitude':8, 'longitude':1.1667};
            latlong.TH = {'latitude':15, 'longitude':100};
            latlong.TJ = {'latitude':39, 'longitude':71};
            latlong.TK = {'latitude':-9, 'longitude':-172};
            latlong.TM = {'latitude':40, 'longitude':60};
            latlong.TN = {'latitude':34, 'longitude':9};
            latlong.TO = {'latitude':-20, 'longitude':-175};
            latlong.TR = {'latitude':39, 'longitude':35};
            latlong.TT = {'latitude':11, 'longitude':-61};
            latlong.TV = {'latitude':-8, 'longitude':178};
            latlong.TW = {'latitude':23.5, 'longitude':121};
            latlong.TZ = {'latitude':-6, 'longitude':35};
            latlong.UA = {'latitude':49, 'longitude':32};
            latlong.UG = {'latitude':1, 'longitude':32};
            latlong.UM = {'latitude':19.2833, 'longitude':166.6};
            latlong.US = {'latitude':38, 'longitude':-97};
            latlong.UY = {'latitude':-33, 'longitude':-56};
            latlong.UZ = {'latitude':41, 'longitude':64};
            latlong.VA = {'latitude':41.9, 'longitude':12.45};
            latlong.VC = {'latitude':13.25, 'longitude':-61.2};
            latlong.VE = {'latitude':8, 'longitude':-66};
            latlong.VG = {'latitude':18.5, 'longitude':-64.5};
            latlong.VI = {'latitude':18.3333, 'longitude':-64.8333};
            latlong.VN = {'latitude':16, 'longitude':106};
            latlong.VU = {'latitude':-16, 'longitude':167};
            latlong.WF = {'latitude':-13.3, 'longitude':-176.2};
            latlong.WS = {'latitude':-13.5833, 'longitude':-172.3333};
            latlong.YE = {'latitude':15, 'longitude':48};
            latlong.YT = {'latitude':-12.8333, 'longitude':45.1667};
            latlong.ZA = {'latitude':-29, 'longitude':24};
            latlong.ZM = {'latitude':-15, 'longitude':30};
            latlong.ZW = {'latitude':-20, 'longitude':30};

            // Dummy data
            var mapData = [
                {'code':'AF' , 'name':'Afghanistan', 'value':32358260},
                {'code':'AL' , 'name':'Albania', 'value':3215988},
                {'code':'DZ' , 'name':'Algeria', 'value':35980193},
                {'code':'AO' , 'name':'Angola', 'value':19618432},
                {'code':'AR' , 'name':'Argentina', 'value':40764561},
                {'code':'AM' , 'name':'Armenia', 'value':3100236},
                {'code':'AU' , 'name':'Australia', 'value':22605732},
                {'code':'AT' , 'name':'Austria', 'value':8413429},
                {'code':'AZ' , 'name':'Azerbaijan', 'value':9306023},
                {'code':'BH' , 'name':'Bahrain', 'value':1323535},
                {'code':'BD' , 'name':'Bangladesh', 'value':150493658},
                {'code':'BY' , 'name':'Belarus', 'value':9559441},
                {'code':'BE' , 'name':'Belgium', 'value':10754056},
                {'code':'BJ' , 'name':'Benin', 'value':9099922},
                {'code':'BT' , 'name':'Bhutan', 'value':738267},
                {'code':'BO' , 'name':'Bolivia', 'value':10088108},
                {'code':'BA' , 'name':'Bosnia and Herzegovina', 'value':3752228},
                {'code':'BW' , 'name':'Botswana', 'value':2030738},
                {'code':'BR' , 'name':'Brazil', 'value':196655014},
                {'code':'BN' , 'name':'Brunei', 'value':405938},
                {'code':'BG' , 'name':'Bulgaria', 'value':7446135},
                {'code':'BF' , 'name':'Burkina Faso', 'value':16967845},
                {'code':'BI' , 'name':'Burundi', 'value':8575172},
                {'code':'KH' , 'name':'Cambodia', 'value':14305183},
                {'code':'CM' , 'name':'Cameroon', 'value':20030362},
                {'code':'CA' , 'name':'Canada', 'value':34349561},
                {'code':'CV' , 'name':'Cape Verde', 'value':500585},
                {'code':'CF' , 'name':'Central African Rep.', 'value':4486837},
                {'code':'TD' , 'name':'Chad', 'value':11525496},
                {'code':'CL' , 'name':'Chile', 'value':17269525},
                {'code':'CN' , 'name':'China', 'value':1347565324},
                {'code':'CO' , 'name':'Colombia', 'value':46927125},
                {'code':'KM' , 'name':'Comoros', 'value':753943},
                {'code':'CD' , 'name':'Congo, Dem. Rep.', 'value':67757577},
                {'code':'CG' , 'name':'Congo, Rep.', 'value':4139748},
                {'code':'CR' , 'name':'Costa Rica', 'value':4726575},
                {'code':'CI' , 'name':'Cote d\'Ivoire', 'value':20152894},
                {'code':'HR' , 'name':'Croatia', 'value':4395560},
                {'code':'CU' , 'name':'Cuba', 'value':11253665},
                {'code':'CY' , 'name':'Cyprus', 'value':1116564},
                {'code':'CZ' , 'name':'Czech Rep.', 'value':10534293},
                {'code':'DK' , 'name':'Denmark', 'value':5572594},
                {'code':'DJ' , 'name':'Djibouti', 'value':905564},
                {'code':'DO' , 'name':'Dominican Rep.', 'value':10056181},
                {'code':'EC' , 'name':'Ecuador', 'value':14666055},
                {'code':'EG' , 'name':'Egypt', 'value':82536770},
                {'code':'SV' , 'name':'El Salvador', 'value':6227491},
                {'code':'GQ' , 'name':'Equatorial Guinea', 'value':720213},
                {'code':'ER' , 'name':'Eritrea', 'value':5415280},
                {'code':'EE' , 'name':'Estonia', 'value':1340537},
                {'code':'ET' , 'name':'Ethiopia', 'value':84734262},
                {'code':'FJ' , 'name':'Fiji', 'value':868406},
                {'code':'FI' , 'name':'Finland', 'value':5384770},
                {'code':'FR' , 'name':'France', 'value':63125894},
                {'code':'GA' , 'name':'Gabon', 'value':1534262},
                {'code':'GM' , 'name':'Gambia', 'value':1776103},
                {'code':'GE' , 'name':'Georgia', 'value':4329026},
                {'code':'DE' , 'name':'Germany', 'value':82162512},
                {'code':'GH' , 'name':'Ghana', 'value':24965816},
                {'code':'GR' , 'name':'Greece', 'value':11390031},
                {'code':'GT' , 'name':'Guatemala', 'value':14757316},
                {'code':'GN' , 'name':'Guinea', 'value':10221808},
                {'code':'GW' , 'name':'Guinea-Bissau', 'value':1547061},
                {'code':'GY' , 'name':'Guyana', 'value':756040},
                {'code':'HT' , 'name':'Haiti', 'value':10123787},
                {'code':'HN' , 'name':'Honduras', 'value':7754687},
                {'code':'HK' , 'name':'Hong Kong, China', 'value':7122187},
                {'code':'HU' , 'name':'Hungary', 'value':9966116},
                {'code':'IS' , 'name':'Iceland', 'value':324366},
                {'code':'IN' , 'name':'India', 'value':1241491960},
                {'code':'ID' , 'name':'Indonesia', 'value':242325638},
                {'code':'IR' , 'name':'Iran', 'value':74798599},
                {'code':'IQ' , 'name':'Iraq', 'value':32664942},
                {'code':'IE' , 'name':'Ireland', 'value':4525802},
                {'code':'IL' , 'name':'Israel', 'value':7562194},
                {'code':'IT' , 'name':'Italy', 'value':60788694},
                {'code':'JM' , 'name':'Jamaica', 'value':2751273},
                {'code':'JP' , 'name':'Japan', 'value':126497241},
                {'code':'JO' , 'name':'Jordan', 'value':6330169},
                {'code':'KZ' , 'name':'Kazakhstan', 'value':16206750},
                {'code':'KE' , 'name':'Kenya', 'value':41609728},
                {'code':'KP' , 'name':'Korea, Dem. Rep.', 'value':24451285},
                {'code':'KR' , 'name':'Korea, Rep.', 'value':48391343},
                {'code':'KW' , 'name':'Kuwait', 'value':2818042},
                {'code':'KG' , 'name':'Kyrgyzstan', 'value':5392580},
                {'code':'LA' , 'name':'Laos', 'value':6288037},
                {'code':'LV' , 'name':'Latvia', 'value':2243142},
                {'code':'LB' , 'name':'Lebanon', 'value':4259405},
                {'code':'LS' , 'name':'Lesotho', 'value':2193843},
                {'code':'LR' , 'name':'Liberia', 'value':4128572},
                {'code':'LY' , 'name':'Libya', 'value':6422772},
                {'code':'LT' , 'name':'Lithuania', 'value':3307481},
                {'code':'LU' , 'name':'Luxembourg', 'value':515941},
                {'code':'MK' , 'name':'Macedonia, FYR', 'value':2063893},
                {'code':'MG' , 'name':'Madagascar', 'value':21315135},
                {'code':'MW' , 'name':'Malawi', 'value':15380888},
                {'code':'MY' , 'name':'Malaysia', 'value':28859154},
                {'code':'ML' , 'name':'Mali', 'value':15839538},
                {'code':'MR' , 'name':'Mauritania', 'value':3541540},
                {'code':'MU' , 'name':'Mauritius', 'value':1306593},
                {'code':'MX' , 'name':'Mexico', 'value':114793341},
                {'code':'MD' , 'name':'Moldova', 'value':3544864},
                {'code':'MN' , 'name':'Mongolia', 'value':2800114},
                {'code':'ME' , 'name':'Montenegro', 'value':632261},
                {'code':'MA' , 'name':'Morocco', 'value':32272974},
                {'code':'MZ' , 'name':'Mozambique', 'value':23929708},
                {'code':'MM' , 'name':'Myanmar', 'value':48336763},
                {'code':'NA' , 'name':'Namibia', 'value':2324004},
                {'code':'NP' , 'name':'Nepal', 'value':30485798},
                {'code':'NL' , 'name':'Netherlands', 'value':16664746},
                {'code':'NZ' , 'name':'New Zealand', 'value':4414509},
                {'code':'NI' , 'name':'Nicaragua', 'value':5869859},
                {'code':'NE' , 'name':'Niger', 'value':16068994},
                {'code':'NG' , 'name':'Nigeria', 'value':162470737},
                {'code':'NO' , 'name':'Norway', 'value':4924848},
                {'code':'OM' , 'name':'Oman', 'value':2846145},
                {'code':'PK' , 'name':'Pakistan', 'value':176745364},
                {'code':'PA' , 'name':'Panama', 'value':3571185},
                {'code':'PG' , 'name':'Papua New Guinea', 'value':7013829},
                {'code':'PY' , 'name':'Paraguay', 'value':6568290},
                {'code':'PE' , 'name':'Peru', 'value':29399817},
                {'code':'PH' , 'name':'Philippines', 'value':94852030},
                {'code':'PL' , 'name':'Poland', 'value':38298949},
                {'code':'PT' , 'name':'Portugal', 'value':10689663},
                {'code':'PR' , 'name':'Puerto Rico', 'value':3745526},
                {'code':'QA' , 'name':'Qatar', 'value':1870041},
                {'code':'RO' , 'name':'Romania', 'value':21436495},
                {'code':'RU' , 'name':'Russia', 'value':142835555},
                {'code':'RW' , 'name':'Rwanda', 'value':10942950},
                {'code':'SA' , 'name':'Saudi Arabia', 'value':28082541},
                {'code':'SN' , 'name':'Senegal', 'value':12767556},
                {'code':'RS' , 'name':'Serbia', 'value':9853969},
                {'code':'SL' , 'name':'Sierra Leone', 'value':5997486},
                {'code':'SG' , 'name':'Singapore', 'value':5187933},
                {'code':'SK' , 'name':'Slovak Republic', 'value':5471502},
                {'code':'SI' , 'name':'Slovenia', 'value':2035012},
                {'code':'SB' , 'name':'Solomon Islands', 'value':552267},
                {'code':'SO' , 'name':'Somalia', 'value':9556873},
                {'code':'ZA' , 'name':'South Africa', 'value':50459978},
                {'code':'ES' , 'name':'Spain', 'value':46454895},
                {'code':'LK' , 'name':'Sri Lanka', 'value':21045394},
                {'code':'SD' , 'name':'Sudan', 'value':34735288},
                {'code':'SR' , 'name':'Suriname', 'value':529419},
                {'code':'SZ' , 'name':'Swaziland', 'value':1203330},
                {'code':'SE' , 'name':'Sweden', 'value':9440747},
                {'code':'CH' , 'name':'Switzerland', 'value':7701690},
                {'code':'SY' , 'name':'Syria', 'value':20766037},
                {'code':'TW' , 'name':'Taiwan', 'value':23072000},
                {'code':'TJ' , 'name':'Tajikistan', 'value':6976958},
                {'code':'TZ' , 'name':'Tanzania', 'value':46218486},
                {'code':'TH' , 'name':'Thailand', 'value':69518555},
                {'code':'TG' , 'name':'Togo', 'value':6154813},
                {'code':'TT' , 'name':'Trinidad and Tobago', 'value':1346350},
                {'code':'TN' , 'name':'Tunisia', 'value':10594057},
                {'code':'TR' , 'name':'Turkey', 'value':73639596},
                {'code':'TM' , 'name':'Turkmenistan', 'value':5105301},
                {'code':'UG' , 'name':'Uganda', 'value':34509205},
                {'code':'UA' , 'name':'Ukraine', 'value':45190180},
                {'code':'AE' , 'name':'United Arab Emirates', 'value':7890924},
                {'code':'GB' , 'name':'United Kingdom', 'value':62417431},
                {'code':'US' , 'name':'United States', 'value':313085380},
                {'code':'UY' , 'name':'Uruguay', 'value':3380008},
                {'code':'UZ' , 'name':'Uzbekistan', 'value':27760267},
                {'code':'VE' , 'name':'Venezuela', 'value':29436891},
                {'code':'PS' , 'name':'West Bank and Gaza', 'value':4152369},
                {'code':'VN' , 'name':'Vietnam', 'value':88791996},
                {'code':'YE' , 'name':'Yemen, Rep.', 'value':24799880},
                {'code':'ZM' , 'name':'Zambia', 'value':13474959},
                {'code':'ZW' , 'name':'Zimbabwe', 'value':12754378}
            ];


            // Configure heatmap
            var max = -Infinity;
            var min = Infinity;
            mapData.forEach(function (itemOpt) {
                if (itemOpt.value > max) {
                    max = itemOpt.value;
                }
                if (itemOpt.value < min) {
                    min = itemOpt.value;
                }
            });

            // Colors
            var mapBackgroundColor = 'var(--map-bg)',
                mapPlaceholderColor = 'var(--map-placeholder-color)',
                mapHoverColor = 'var(--map-hover-color)',
                mapBorderColor = 'var(--map-border-color)',
                scatterColor = ['#FFC600', '#30D27C'];

            // Options
            map_world.setOption({

                // Map background color
                backgroundColor: mapBackgroundColor,

                // Global text style
                textStyle: {
                    fontFamily: 'var(--body-font-family)',
                    color: 'var(--body-color)',
                    fontSize: 14,
                    lineHeight: 22,
                    textBorderColor: 'transparent'
                },

                // Tooltip
                tooltip: {
                    trigger: 'item',
                    className: 'shadow-sm rounded',
                    backgroundColor: 'var(--white)',
                    borderColor: 'rgba(var(--black-rgb), 0.5)',
                    padding: [10, 15],
                    textStyle: {
                        color: '#000'
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(var(--body-color-rgb), 0.025)'
                        }
                    }
                },

                // Map config
                geo: {
                    type: 'map',
                    map: 'world',
                    roam: true,
                    zoom: 1.25,
                    aspectScale: 0.85,
                    scaleLimit: {
                        min: 1.25,
                        max: 3
                    },
                    label: {
                        emphasis: {
                            show: false
                        }
                    },
                    itemStyle: {
                        normal: {
                            areaColor: mapPlaceholderColor,
                            borderColor: mapBorderColor,
                            borderWidth: 1
                        },
                        emphasis: {
                            areaColor: mapHoverColor
                        }
                    }
                }
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            map_world_element && map_world.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelectorAll('.sidebar-control');
        if (sidebarToggle) {
            sidebarToggle.forEach(function(togglers) {
                togglers.addEventListener('click', triggerChartResize);
            });
        }

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _mapWorldExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsMapWorld.init();
});
