-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2022. Már 30. 19:09
-- Kiszolgáló verziója: 10.4.21-MariaDB
-- PHP verzió: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `my_ota`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `accms`
--

CREATE TABLE `accms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `accm_type` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `languages` varchar(255) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `facilities` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `webpage` varchar(255) DEFAULT NULL,
  `last_modified` int(11) DEFAULT NULL,
  `last_modified_by_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `accms`
--

INSERT INTO `accms` (`id`, `name`, `location`, `slug`, `address`, `accm_type`, `price`, `capacity`, `description`, `languages`, `rooms`, `bathrooms`, `facilities`, `contact_name`, `email`, `phone`, `webpage`, `last_modified`, `last_modified_by_user_id`) VALUES
(1, 'Szeifert Hotel', 'Szováta', 'szeifert-hotel-szovata', '{\"postalCode\":\"\",\"street\":\"Bradului\",\"number\":\"28\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 120, 100, 'A szálloda Szovátán, a jól ismert Medve-tó-tól 260 méterre, a Fekete-tó partján helyezkedik el. A Hotel Szeifert szaunával, pezsgőfürdővel, (fizetős szolgáltatás - előzetes bejelentkezéssel a recepción) valamint ingyenes Wi-Fi-hozzáféréssel és vezetékes i', '[\"HUN\",\"ROM\",\"ENG\"]', 40, 40, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Kenyeres Zsolt', 'kenyereszsolt920210+szeifert@gmail.com', '0726185563', 'https://hotelszeifert.ro/hu/', 1646584511, 1),
(2, 'Csatári Panzió', 'Parajd', 'csatari-panzio-parajd', '{\"postalCode\":\"\",\"street\":\"Tanorok\",\"number\":\"1145\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 70, 52, 'Az üdülés idejére vendégeink, igényeik szerint, két- három- és négyágyas, tusolóval és mosdóval ellátott szobákban szállhatnak meg. Ugyanakkor igénybe vehetik éttermünket is, tágas teraszunkat és nyári kertünket is.', '[\"HUN\",\"ROM\",\"ENG\"]', 17, 17, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Csatári Recepció', 'kenyereszsolt920210+csatari@gmail.com', '0726185563', 'csatari.ro', 1646581679, 1),
(4, 'Septimia Resort & SPA', 'Székelyudvarhely', 'septimia-resort-spa-szekelyudvarhely', '{\"postalCode\":\"\",\"street\":\"Orb\\u00e1n Bal\\u00e1zs\",\"number\":\"106\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 300, 82, 'Septimia - Hotels & SPA Resort ideális hely a kellemes kikapcsolódáshoz, pihenéshez vagy akár üzleti találkozókhoz!\r\n\r\nA szabadidőközpont Erdély keleti részén, a Hargita hegység lábánál, Székelyudvarhelyen található.', '[\"HUN\",\"ROM\",\"ENG\"]', 33, 33, '[\"MEA\",\"INT\",\"PRK\",\"AIR\",\"HEA\",\"WEL\",\"POL\"]', 'Septimia Recepció', 'kenyereszsolt920210+septimia@gmail.com', '0726185563', 'septimiaresort.ro', 1646581718, 1),
(9, 'Lobogó Resort', 'Homoródfürdő', 'lobogo-resort-homorodfurdo', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"39\",\"building\":\"A\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 300, 100, 'Éttermünk, panziónk és a szabadidőközpont is a helyiek körében legkedveltebb, Lobogó forrásról kapta a nevét.\r\n\r\nA Lobogó forrás vize szénsavas, nátriumkloridos, alkaikus, vasas ásványvíz. Ivókúraképpen javasolt idült, savszegény vagy savhiányos gyomorhártya gyulladásra, valamint idült máj és epebántalmakra, fürdővízképpen szív és érrendszeri betegségekben szenvedőknek ajánlott.\r\n\r\nA Lobogó panzió, étterem és szabadidő központ a Hargita hegység lábánál, fenyvesekkel körülölelt, gyógyhatású ásványvízforrásokban bővelkedő völgyben terül el. A komplexum területén őrzött parkoló áll a vendégeink rendelkezésére.', '[\"HUN\",\"ROM\",\"ENG\"]', 35, 35, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\",\"POL\"]', 'Recepció', 'kenyereszsolt920210+lobogo@gmail.com', '0726185563', 'lobogo.ro', 1644135856, 1),
(10, 'Hotel O3zone', 'Tusnádfürdő', 'hotel-o3zone-tusnadfurdo', '{\"postalCode\":\"\",\"street\":\"Szent Anna s\\u00e9t\\u00e1ny\",\"number\":\"2\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 300, 234, 'Az O3zone szállodai komplexum a nemzetközileg elismert Tusnádfürdőn található, mely hírnevét az itt található ásványvizek gyógyhatásának, oxigéndús levegőjének, és kiváló természeti adottságainak köszönheti. A fürdőhelység az ország középpontjában, Sepsiszentgyörgytől 30, Brassótól 60, Csíkszeredától, pedig 30 km-re terül el, a vulkanikus Csomád hegység lejtőjén, a Szent Anna tó közelében.\r\n\r\nMivel szállodánk Tusnádfürdő központjában helyezkedik el, a Solyóm szikla közelében, ezért az O3zone komplexum kiemelkedő pozíciót foglal el, nem csupán elhelyezkedése, hanem kimagasló szolgáltatásainak is köszönhetően. Úgy gondoljuk, hogy az általunk nyújtott szolgáltatások, és mindazon pozitív élmények, amelyekekkel az itt töltött idő alatt gazdagodnak, szállodánkat az önök által eddig látogatott helyek toplistájára fogják juttatni.', '[\"HUN\",\"ROM\",\"ENG\",\"GER\",\"ITA\"]', 117, 117, '[\"MEA\",\"INT\",\"PRK\",\"AIR\",\"HEA\",\"WEL\",\"POL\"]', 'O3zone Recepció', 'kenyereszsolt920210+o3zone@gmail.com', '0726185563', 'o3zone.ro', 1644135888, 1),
(11, 'Hétvezér Panzió', 'Hétvezér Recepció', 'hetvezer-panzio-hetvezer-recepcio', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"73\",\"building\":\"B\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 115, 24, 'Utazzon Székelyföld szívébe, a Hétvezér Panzió várja Önt. Ha meg szeretné látogatni Székelyföld nevezetességeit, szálláshelyül válassza a Hétvezér Panziót, ahol minőségi szolgáltatások közül válogathat Ön és a kedves családja. Egy panzió és két kulcsosház áll a vendégeink rendelkezésére. A panzióban 8 szoba, 2-3-4 ágyasak, minden szobában külön fürdőszoba található. A kulcsosházakban 4-4 szoba és 2-2 fürdőszoba áll a vendégeink rendelkezésére. A területen különböző kikapcsolódási lehetőségek közül válogathat, úgy, mint a medence, szauna, kosárlabda, foci, asztalitenisz, horgászat, tollaslabda, gyerek játszótér, kerti sütők, billiárd, darts. Ezeken kívül igény szerint biztosítunk lehetőséget lovaglásra,medvelesre szánozásra, vadas-park látogatásra, mesterségek bemutató, ATV használatra. Ingyenes WIFI-t is igénybe vehetik.', '[\"HUN\",\"ROM\",\"ENG\"]', 8, 8, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"POL\"]', 'Lőrincz Magor', 'kenyereszsolt920210+hetvezer@gmail.com', '0726185563', 'hetvezerpanzio.ro', 1646581751, 1),
(12, 'Sugó Panzió', 'Ivó', 'sugo-panzio-ivo', '{\"postalCode\":\"\",\"street\":\"Madarasi Hargita\",\"number\":\"\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 160, 59, 'Erdély egyik legszebb területén, a székelyek szent hegyén, a Madarasi Hargitán (Székelyudvarhelytől 36 km) 2006-ban nyitottuk meg panziónkat. A ház egész évben nyitva tart és az évszaknak megfelelő szabadidős programokkal áll a pihenésre, kikapcsolódásra, feltöltődésre vágyó vendégek rendelkezésére.\r\n\r\nA földszinten található 72 fős éttermünkben bőséges büféreggelivel kezdhetik a napot kedves vendégeink. Igény esetén félpanziós és teljes panziós ellátást is tudunk biztosítani, de lehetőség van á la carte fogyasztásra is a nemzetközi, magyaros és erdélyi ételeket tartalmazó étlapról.\r\n\r\nLehetőség van síelésre, túrázásra, paintballozásra, valamint – előzetes bejelentkezés alapján –masszázsra, lovaglásra, terepjárós kalandtúrára. Tarthatnak nálunk kisebb konferenciákat, csapatépítő tréningeket, továbbképzéseket, melyekhez a szükséges technikai hátteret mi biztosítjuk.\r\n\r\nSzeretettel várjuk minden évszakban úgy a felnőtt, mint az iskolás csoportokat e festői szépségű helyen, amely ideális kiindulópontja úgy a gyalogos, mint az autós csillagtúráknak.', '[\"HUN\",\"ROM\",\"ENG\"]', 14, 12, '[\"INT\",\"PRK\",\"HEA\"]', 'Sugó Recepció', 'kenyereszsolt920210+sugo@gmail.com', '0726185563', 'sugopanzio.ro', 1646581779, 1),
(13, 'Enikő Kulcsosház', 'Güdüctelep', 'eniko-kulcsoshaz-guductelep', '{\"postalCode\":\"\",\"street\":\"\\u00c9g\\u00e9s patak\",\"number\":\"1470\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'CHA', 50, 20, '', '[\"HUN\",\"ROM\"]', 5, 3, '[\"PRK\",\"HEA\"]', 'Enikő Recepció', 'kenyereszsolt920210+eniko@gmail.com', '0726185563', '', 1646581805, 1),
(14, 'Páva Panzió & Wellness', 'Székelyudvarhely', 'pava-panzio-wellness-szekelyudvarhely', '{\"postalCode\":\"\",\"street\":\"Templom\",\"number\":\"15\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 220, 44, 'KEZDETEK\r\n\r\nA Páva története egészen 2008-ig nyúlik vissza, amikor a Villa Vitae wellnessközpont és Pávakert étterem megnyitotta kapuit, majd közel tíz évig gyakorlatilag változatlan formában működött. Gazdát többször is cserélt, és a hely szelleme mindig különleges, egyedi volt, ám az utóbbi időben kissé már elhanyagolttá vált.\r\n\r\nÚJ IDŐK\r\n\r\nAztán 2018 elején vette gondozásába egy család, így azóta az ő vigyázó szemeik mellett bontogatja újra szárnyait. Tervekben bővelkedik a csapat – az út nem lesz rövid, de bővülni fog a szálloda, szépül és új funkciókat kap a hatalmas kert, megújul a wellness, és teljesen újragondolt étterem várja azokat, akik nem csak enni akarnak, hanem az ízekben is szeretik a változatosságot.', '[\"HUN\",\"ROM\"]', 15, 15, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Páva Recepció', 'kenyereszsolt920210+pava@gmail.com', '0726185563', 'pava.ro', 1646581820, 1),
(15, 'Tip-Top Panzió', 'Kalotaszentkirály', 'tip-top-panzio-kalotaszentkiraly', '{\"postalCode\":\"407515\",\"street\":\"Templom\",\"number\":\"304\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 60, 18, 'Ha a kedves vendeg pihenni akar akkor a panzionkba erre megvan minden lehetosege. Nagyon kenyelmes es oszkonfortos a panzionk. Szeretunk finom erdelyi eteleket fozni. S ami meg nagyon fontos : mi tenyleg szeretettel fogadjuk a vendegeket!\r\n\r\nSzilveszterre, Karácsonyra, Húsvétra és Pünkösdre magasabbak az árak, megegyezés alapján történnek a foglalasok, és ilyenkor 25% eloleget kerunk.', '[\"HUN\",\"ROM\",\"ENG\",\"GER\"]', 6, 5, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'TipTop Recepció', 'kenyereszsolt920210+tiptop@gmail.com', '0726185563', '', 1646581838, 1),
(16, 'Szentkirály Panzió', 'Kalotaszentkirály', 'szentkiraly-panzio-kalotaszentkiraly', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"304\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 100, 22, '', '[\"HUN\",\"ROM\",\"ENG\"]', 7, 7, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Szentkirály Recepció', 'kenyereszsolt920210+szentkiraly@gmail.com', '+40726185563', '', 1646581860, 1),
(22, 'Rossmarkt Haus', 'Brassó', 'rossmarkt-haus-brasso', '{\"postalCode\":\"\",\"street\":\"George Baritiu\",\"number\":\"3\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 185, 13, 'Megfelelő választás azoknak a látogatóknak, akik történelemmel teli helyet keresnek. Az egyik legrégebbi épület Brassóban (1493), a 2019-es teljes felújítás után a Rossmarkt a 21. századi kényelmet és egyedülálló élményt nyújt a 15. század történelmében. Négy szobánkat az első és a második emeleten rendeztük el, Brassó óvárosának egyik legjobban megőrzött történelmi örökség épületében.', '[\"HUN\",\"ROM\",\"ENG\",\"GER\"]', 4, 4, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Rossmarkt Recepció', 'kenyereszsolt920210+rossmarkt@gmail.com', '+40726185563', 'rossmarkt.ro', 1646581882, 1),
(23, 'Lilla Apartmanok', 'Székelyudvarhely', 'lilla-apartmanok-szekelyudvarhely', '{\"postalCode\":\"\",\"street\":\"Malom\",\"number\":\"9\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'APT', 180, 12, 'Apartmanjaink ideálisak családoknak, baráti társaságoknak, hiszen az 52 négyzetméteres lakásban kényelmesen elfér 4-5 személy. Két szobával rendelkeznek, a nagyobb szobában egy franciaágy és egy különágy, a kisebb szobában pedig két külön ágy található. A konyha hűtőszekrénnyel, mélyhűtővel, kályhával, mikróval, kávéfőzővel, vízforralóval, evőeszközökkel ellátott, így könnyedén elkészítheted kedvenc reggelidet és együtt vacsorázhat a baráti társaság. Autódat biztonságban tudhatod a lakások melletti zárt parkolóban, amelyhez saját távirányítód lesz az itt tartózkodásod alatt.', '[\"HUN\",\"ROM\",\"ENG\"]', 6, 3, '[\"INT\",\"PRK\",\"HEA\"]', 'Lilla Apartmanok', 'kenyereszsolt920210+lilla@gmail.com', '+40726185563', 'lillapanzio.ro', 1644136052, 1),
(24, 'Piricske Pihenőház', 'Piricske', 'piricske-pihenohaz-piricske', '{\"postalCode\":\"\",\"street\":\"Piricske\",\"number\":\"23\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'CHA', 70, 14, 'A Piricske Pihenőház Hargita megyében található, 15 percnyi autóútra Csíkszeredától és 45 percnyi autóútra Székelyudvarhelytől. A Hargitai havasok fenyveseivel körbevett 150 nm-es erdei faház 2000-ben épült, majd 2016-ban egy teljes felújításon esett át, így mai állapotában egy minden igényt kielégítő „meseház” lett.\r\n\r\nA ház berendezése és stílusa a régi és modern divatot egyaránt kedvelő tulajdonosokat dicséri, mely gondosan összeválogatott helyi és külföldi tárgyakból, bútorokból áll, ügyesen vegyítve a legmodernebb elemekkel. A teraszon elénk tárul a hargitai fenyves erdő, háttérben a gyönyörű Csíki-medencével. A házhoz tartozó 1200 nm-es telken lehetőség van bográcsozásra, flekkensütésre és mindenféle szabadtéri játékra.', '[\"HUN\",\"ROM\",\"ENG\",\"GER\"]', 5, 2, '[\"INT\",\"PRK\",\"HEA\"]', 'Piricske Pihenőház', 'kenyereszsolt920210+piricske@gmail.com', '+40726185563', 'piricskepihenohaz.hu', 1644136101, 1),
(25, 'Csángó-Fatányéros Panziók', 'Hidegség', 'csango-fatanyeros-panziok-hidegseg', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"980\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 82, 87, 'A panzió az erdélyi Csíki-havasokban, Hargita megyében, Csíkszeredától (rom. Miercurea Ciuc) ÉK irányban 40 km-re fekvő Gyímesközéplok (rom. Lunca de Jos) községhez tartozó Hidegség (rom. Valea Rece) helységben található a 127A úton, GPS koordináták 46.60039 N/25.97685 E, Google Maps térkép. Autóval egész évben megközelíthető, jó minőségű aszfaltúton. A legközelebbi vasútállomás a Gyímesközéplok-i(rom. Lunca de Mijloc) 3,5 km található, az 501-es CFR vasútvonalon.', '[\"HUN\",\"ROM\"]', 31, 31, '[\"MEA\",\"INT\",\"PRK\"]', 'Csángó-Fatányéros Panziók', 'kenyereszsolt920210+csango@gmail.com', '+40726185563', 'csangopanzio.ro', 1644136119, 1),
(26, 'Anda Panzió', 'Gyergyószentmiklós', 'anda-panzio-gyergyoszentmiklos', '{\"postalCode\":\"\",\"street\":\"KM 5\",\"number\":\"\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 70, 42, 'Gyönyörű környezetben patak partján helyezkedik el a panzió.Nagyon csendes környezetben vagyunk a hegyek között ,a tengerszint fölött 900 méterre,közvetlenen a fő közlekedésű út mellett. Foglalható nálunk családi szoba jakuzzi és szaunával, valamint bővültünk kinti dézsával és száraz szaunával.Mindenkit várunk szeretettel.', '[\"HUN\",\"ROM\",\"ENG\",\"GER\"]', 15, 14, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Anda Recepció', 'kenyereszsolt920210+anda@gmail.com', '+40726185563', 'andapanzio.ro/', 1646581903, 1),
(27, 'Dr. Demeter Béla Vendégház', 'Torockó', 'dr-demeter-bela-vendeghaz-torocko', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"55\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'GHS', 125, 40, 'Felejthetetlen pihenes a Szekelyko labanal! Nagy szeretettel varjuk!', '[\"HUN\",\"ROM\",\"ENG\",\"FRA\",\"ESP\"]', 14, 14, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Demeter Recepció', 'kenyereszsolt920210+demeter@gmail.com', '+40726185563', '', 1646581917, 1),
(28, 'Dulo Annamária Vendégház', 'Torockó', 'dulo-annamaria-vendeghaz-torocko', '{\"postalCode\":\"\",\"street\":\"K\\u0151v\\u00e1r\",\"number\":\"63\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'GHS', 140, 11, 'Töltsön egy pár napot a rusztikusan kialakított vendégházunkban, pihenjen a százéves diófa alatt csodálva a hegyeket, kóstolja meg a hagyományos torockói ízeket, saját készítésű pálinkát, lekvárokat, zakuszkát. Mássza meg a Székelykövet és járja be a környék nevezetességeit vagyis érezze jól magát.', '[\"HUN\",\"ROM\",\"ENG\"]', 5, 4, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Dulo Recepció', 'kenyereszsolt920210+dulo@gmail.com', '+40726185563', '', 1646581930, 1),
(34, 'Daniel Kastélyszálló', 'Olasztelek', 'daniel-kastelyszallo-olasztelek', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"215\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 222, 40, 'Az Olasztelek (Tălişoara) településén épült Castle Hotel Daniel helyszíni étteremmel és elegáns szobákkal, valamint ingyenes Wi-Fi-hozzáféréssel várja vendégeit 50 km-re Brassótól.\r\n\r\nA tágas, középkori stílusú szobák síkképernyős kábel-TV-vel felszereltek. A privát fürdőszobák stílusos fürdőkáddal és papuccsal rendelkeznek.\r\n\r\nA Castle Hotel Daniel nagy kerttel, terasszal és grillezési lehetőséggel is rendelkezik. A szálloda bárjában italok fogyaszthatók, a legkisebbeket pedig játékterem és játszótér várja. A szálláshelyen díjmentes parkolási lehetőség biztosított.', '[\"HUN\",\"ROM\",\"ENG\"]', 20, 20, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Daniel Recepció', 'kenyereszsolt920210+daniel@gmail.com', '+40726185563', 'danielcastle.ro', 1646581971, 1),
(35, 'Wooden Attic Suite', 'Brassó', 'wooden-attic-suite-brasso', '{\"postalCode\":\"\",\"street\":\"Caramideriei\",\"number\":\"31\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'APT', 125, 6, '', '[\"ROM\",\"ENG\"]', 1, 1, '[\"INT\",\"PRK\",\"HEA\"]', 'Wooden Recepció', 'kenyereszsolt920210+wooden@gmail.com', '+40726185563', 'coronahomes.ro', 1646581988, 1),
(36, 'Hunnia - Huntanya', 'Szentegyháza', 'hunnia-huntanya-szentegyhaza', '{\"postalCode\":\"\",\"street\":\"Republicii\",\"number\":\"47\",\"building\":\"K\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 190, 22, '', '[\"HUN\",\"ROM\",\"ENG\"]', 7, 7, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Hunnia', 'kenyereszsolt920210+hunnia@gmail.com', '+40726185563', '', 1643359320, 1),
(37, 'Cheminee Apartman', 'Brassó', 'cheminee-apartman-brasso', '{\"postalCode\":\"\",\"street\":\"Muresenilor\",\"number\":\"17\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'APT', 80, 4, 'Brassó régi és bájos városának szívében elhelyezkedő apartmanjaink felejthetetlen tartózkodást kínálnak a hangulatuknak köszönhetően, amely egyedülálló módon olvasztja össze az ősi és a modern épületet. Minden apartmanszobát nemrégiben felújítottak, megőrizve az eredeti karaktert. Megcsodálhatja a csodálatos fa szobrokat az ablakokon és ajtókon, amelyek a XIX. Század végéig nyúlnak vissza. A szoba nagysága nagyvonalú, és 4m magasságukkal nagyszerű tágas érzés érhető el. A modern stílusban a bútorok egy modern szálláshely kényelmét kínálják.', '[\"ROM\",\"ENG\"]', 2, 1, '[\"INT\",\"HEA\"]', 'Select City Center Apartments', 'kenyereszsolt920210+select@gmail.com', '+40726185563', 'select-apartments-brasov.ro', 1643359410, 1),
(38, 'Cluj ApartHotel', 'Kolozsvár', 'cluj-aparthotel-kolozsvar', '{\"postalCode\":\"\",\"street\":\"Regele Ferdinand\",\"number\":\"19\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'APT', 68, 12, 'A Cluj ApartHotel pillanatnyilag 4 apartmant jelent egy 1894-ben épült épületben, de azt tervezzük, hogy kibővítjük :) Az épületet Rucska Lajos magyar építész tervezte, és Kolozsvár építészeti fejlesztésének legszebb időszakában épült ( 19. század). Úgy éreztük, hogy a valóság időszaka alatt azt gondoltuk, hogy \"királyi\" apartmanokban élünk: Az első apartmant (I. Ferdinánd király után nevezték el) 2016 tavaszán nyitottuk meg a teljes felújítás után, és egy modern módon berendezett apartman, amely igazodik a kolozsvári mindennapi városi élethez. 2016 őszén kinyitottuk a második, I. Carol király után elnevezett, Carol lakást, és klasszikus-modern stílusban rendeztuk be. Érdekesnek találtuk, hogy a Ramontianu család, az értelmiségiek családjának néhány festményét őrizze meg ebben a lakásban az 1920-as évekből. Emellett megtartottuk és helyreállítottuk az eredeti ajtót, hogy hozzáférhessünk a lakáshoz, valamint néhány családi bútorhoz. 2018-ban további két apartmant nyitottunk (Ana és Mihai), az Ana egy 1-2 fős stúdió, a Mihai pedig 4 fő elszállásolására alkalmas.', '[\"ROM\",\"ENG\"]', 3, 3, '[\"INT\",\"PRK\",\"HEA\"]', 'ApartHotel Recepció', 'kenyereszsolt920210+aparthotel@gmail.com', '+40726185563', '', 1646582013, 1),
(39, 'Viscri 195 Panzió', 'Szászfehéregyháza', 'viscri-195-panzio-szaszfeheregyhaza', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"195\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'GHS', 125, 11, '', '[\"ROM\",\"ENG\"]', 4, 5, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Viscri Recepció', 'kenyereszsolt920210+viscri@gmail.com', '+40726185563', 'viscri195.ro', 1646582026, 1),
(40, 'Haller Kastélyszálló', 'Marosugra', 'haller-kastelyszallo-marosugra', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"466\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 170, 36, 'A múlt idők eleganciáját sugárzó történelmi Erdély első Kastélyszállója.\r\n\r\nMarosvásárhelytől 22 km-re a Maros bal partján, a Kolozsvár-Marosvásárhely országút (E60) mellett fekszik, 9 km-re a Marosvásárhelyi Nemzeti Repülőtértól.\r\n\r\nA Kastély a XVII. században épült klasszicista barokk stílusban. A 90-s évek során különböző tevékenységeket folytató intézményeknek helyet adó Kastélyban ( iskola, óvoda, irodahelyiség, raktárhelység, bentlakás, pékség stb.) 2012 óta szálloda, étterem és borospince működik.\r\n\r\nA Kastélyszálló termei, szabadtéri adottságai, alkalmassá teszik kongreszusok, konferenciák, tanácskozások, továbbképzések, szemináriumok, esküvők, eljegyzések, keresztelők, koktélpartik, fogadások, díszvacsorák, bálok, koncertek, hangversenyek és egyébb üzleti és családi rendezvények.', '[\"HUN\",\"ROM\",\"ENG\",\"GER\",\"ESP\"]', 13, 14, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Haller Recepció', 'kenyereszsolt920210+haller@gmail.com', '+40726185563', 'castelhaller.ro', 1646582038, 1),
(41, 'Versay Hotel', 'Herkulesfürdő', 'versay-hotel-herkulesfurdo', '{\"postalCode\":\"\",\"street\":\"Cernei\",\"number\":\"1\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 240, 52, '', '[\"ROM\",\"ENG\",\"ITA\"]', 27, 27, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Recepció', 'kenyereszsolt920210+versay@gmail.com', '+40726185563', 'hotel-versay.ro', 1643363334, 1),
(42, 'Ambient Hotel', 'Brassó', 'ambient-hotel-brasso', '{\"postalCode\":\"\",\"street\":\"Iuliu Maniu\",\"number\":\"27\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 405, 150, 'Eleganciát és kényelmet keres? Mindig megtalálja, ha meglátogatja a Hotel Ambient-t (Brassó), amely már hagyománynév, és több mint egy évtizedes kiválósággal és tapasztalattal rendelkezik.\r\n\r\nA Hotel Ambient ideális helyen, Brassó központjában található, néhány percre a történelmi emlékektől, híres bároktól és csillogási üzletektől, amelyekből szép kilátás nyílik az egész városra. Ez a luxus referenciája a nemzetközi vásárlók számára.\r\n\r\nHelyszínünk vendégeként tágas szálláslehetőségeket és személyre szabott szolgáltatásokat fedez fel.\r\n\r\nA 4 csillagos szálloda kielégíti a modern turisták legnagyobb elvárásait. 71 kényelmes és nagy szobával, új és modern adottságokkal várjuk vendégeinket.', '[\"ROM\",\"ENG\",\"GER\",\"ITA\",\"FRA\",\"ESP\"]', 71, 80, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\",\"POL\"]', 'Euro Tour', 'kenyereszsolt920210+ambient@gmail.com', '+40726185563', 'hotelambient.ro', 1643364689, 1),
(43, 'Ensana Hotel', 'Szováta', 'ensana-hotel-szovata', '{\"postalCode\":\"\",\"street\":\"R\\u00f3zs\\u00e1k\",\"number\":\"111\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'HOT', 300, 334, 'A sós vízű Medve-tótól csupán 200 méterre fekvő Ensana **** Szováta elsőként megnyílt négycsillagos szállodája, 2004-ben Románia legjobb szállodájának választották.\r\n\r\nA teljesen felújított hotel saját gyógyászati központtal, konferenciatermekkel és wellness szolgáltatásokkal várja Önt. A wellness részlegben télen is bármikor élvezheti a sós vizet a szálloda medencéjében, melyet a Medve-tó vize táplál.\r\n\r\nAmellett, hogy remek lehetőségeket kínál a pihenni és gyógyulni vágyóknak, a hotel ideális kiindulópontja emlékezetes erdélyi kirándulásoknak is.\r\n\r\nHa összekapcsolná az üzletet a kikapcsolódással, akkor sem fog csalódni - a szállodában egy helyen biztosítottak wellness- és konferencia-lehetőségek, 9 konferenciaterem elérhető 14-300 fős kapacitással.', '[\"HUN\",\"ROM\",\"ENG\"]', 168, 168, '[\"MEA\",\"INT\",\"PRK\",\"WEL\"]', 'Ensana Recepció', 'kenyereszsolt920210+ensana@gmail.com', '+40726185563', 'ensanahotels.com/hotel-sovata', 1646582057, 1),
(44, 'Harmónia Mundi', 'Magyarfenes', 'harmonia-mundi-magyarfenes', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"424\",\"building\":\"F\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 190, 24, 'A panzió 4 napfényes és tágas szobával, 2 családi lakosztállyal várja vendégeit. Minden szobához fürdőszoba tartozik, melynek stílusában a modern és a hagyományos elemek harmonikusan ötvöződnek. Azok részére, akik hosszabb ideig szeretnének itt tartózkodni, egy külön bejáratú apartmant ajánlunk, ehhez 2 hálószoba, 2 fürdőszoba, egy nappali étkezővel és egy jól felszerelt konyha tartozik. A háztartási készülékek (pl. mosógép és mosogatógép) teljes kényelmet biztosítanak. Minden szobához HD minőségű televízió tartozik digitális csatornákkal. A fürdőszobák step-in típusú zuhanyzófülkével és hajszárítóval vannak felszerelve.\r\n\r\nA bejárati fogadóteremben, kandallóban lobogó tűz előtt egy finom kávét vagy teát fogyaszthatsz. Az étkezőhöz egy teljesen felszerelt látványkonyha tartozik (villanytűzhely, hűtőszekrény, automata kávéfőző, kenyérpirító, etc.), ez minden vendég rendelkezésére áll. Az étkezőben egy búboskemencét építettünk, amely hagyományos és nemzetközi ételek elkészítésére alkalmas (házikenyér, kalács, töltöttkáposzta, pizza stb.).', '[\"HUN\",\"ROM\",\"ENG\",\"GER\",\"ITA\",\"FRA\"]', 7, 9, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Harmónia Recepció', 'kenyereszsolt920210+mundi@gmail.com', '+40726185563', 'castellumharmoniamundi.ro', 1646582075, 1),
(48, 'Oasis Rural Kulcsosház', 'Cegőtelke', 'oasis-rural-kulcsoshaz-cegotelke', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"88\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'CHA', 83, 9, '', '[\"HUN\",\"ROM\",\"ENG\",\"GER\",\"ITA\"]', 3, 3, '[\"INT\",\"PRK\",\"HEA\"]', 'Oasis Recepció', 'kenyereszsolt920210+oasis@gmail.com', '+40726185563', '', 1646582087, 1),
(49, 'Casa Bertha Panzió', 'Segesvár', 'casa-bertha-panzio-segesvar', '{\"postalCode\":\"\",\"street\":\"Tamplarilor\",\"number\":\"28\",\"building\":\"\",\"floor\":\"\",\"door\":\"2\"}', 'PNS', 175, 9, 'A Casa Bertha egy középkori ház, amely Sighisoara erődjén belül található, amely az UNESCO örökségének része. Nagyon közel van a város összes látnivalóihoz.\r\n\r\nA szobák remek kialakításúak, régi restaurált bútorokkal és a környékről gyűjtött tárgyakkal, amelyek mindegyike a középkori erődet építő és védő legfontosabb céheknek szól.\r\n\r\nA szobák síkképernyős kábel TV-vel, hajszárítóval, ingyenes piperecikkekkel, saját fürdőszobával és ingyenes Wi-Fi-vel felszereltek.\r\n\r\nA földszinten van egy pince, amely bárként működik, a bejáratnál pedig egy antik üzlet és egy erdélyi művészet. A létesítményben közeli szabadidős területek, például éttermek, teraszok, pubok és kézműves üzletek és élelmiszerbolt található. Van egy fizetős parkoló 100 méterre.', '[\"HUN\",\"ROM\",\"ENG\",\"ESP\"]', 4, 4, '[\"MEA\",\"INT\",\"HEA\"]', 'Bertha', 'kenyereszsolt920210+bertha@gmail.com', '+40726185563', 'casabertha.ro', 1644136319, 1),
(50, 'Hillside Heaven Kulcsosház', 'Parajd', 'hillside-heaven-kulcsoshaz-parajd', '{\"postalCode\":\"\",\"street\":\"F\\u0171r\\u00e9szoldal\",\"number\":\"1199A\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'CHA', 93, 7, 'Öt perc gyalog a bányáig, a sóvizes strandig, üzlethez, bankautomatához, vendéglőhöz, tíz perc autóval Szováta. Mindazonáltal intim, megóv a turisták zsongásától, teljesen felszerelt, lélegzetelállító kilátással rendelkező tágas villa. Parkolóhely a ház előtt. Házi állatokat is szívesen látunk!', '[\"HUN\",\"ROM\",\"ENG\"]', 3, 2, '[\"INT\",\"PRK\",\"HEA\"]', 'Hillside Recepció', 'kenyereszsolt920210+hillside@gmail.com', '+40726185563', 'hillside.ro', 1646582106, 1),
(51, 'Veranda Panzió és Étterem', 'Gyergyóremete', 'veranda-panzio-es-etterem-gyergyoremete', '{\"postalCode\":\"\",\"street\":\"Orb\\u00e1n Bal\\u00e1zs\",\"number\":\"37\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 84, 40, 'A Veranda Panzió és Étterem Székelyföldön, Hargita megyében, Gyergyóremetén található, 2,2 km-re a község központjától, egy csendes helyen, amely tökéletes lehetőséget kínál a kikapcsolódásra vágyó vendégeknek. A kapun belépve tágas parkoló van az ideutazók számára, a hallban rakottkályha és társalgó biztosítja a vendégek utazás utáni kikapcsolódásat.\r\n\r\nA szobák letisztult eleganciával vannak berendezve, teraszaikról csodálatos kilátás nyílik a gyergyói medencére és hegyeire. A földszinten 3 családi szoba, az emeleten 10 kétszemélyes szoba, valamint 2 négy ágyas szoba található.\r\n\r\nA felső szinten konferenciaterem és gyerekek számára kialakított helyiség áll az érdeklődők rendelkezésére.', '[\"HUN\",\"ROM\",\"ENG\"]', 15, 15, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Veranda Recepció', 'kenyereszsolt920210+veranda@gmail.com', '+40726185563', '', 1646582127, 1),
(52, 'Nádas Panzió', 'Szék', 'nadas-panzio-szek', '{\"postalCode\":\"\",\"street\":\"III\",\"number\":\"258\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 85, 12, '', '[\"HUN\",\"ROM\",\"ENG\"]', 6, 8, '[\"MEA\",\"INT\",\"PRK\",\"HEA\"]', 'Nádas Recepció', 'kenyereszsolt920210+nadas@gmail.com', '+40726185563', 'nadaspanzio.ro', 1646582140, 1),
(53, 'Németh Panzió', 'Szováta', 'nemeth-panzio-szovata', '{\"postalCode\":\"\",\"street\":\"Rachitei\",\"number\":\"46\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 105, 40, 'Vendegházunk 46 férőhellyel rendelkezik, 6 db. kétszemélyes franciaágyas, 2 db. apartman valamint 7 db. négyszemélyes ( 1 francia- és 1 emeletes-ágy) szobával\r\n\r\n– Wellness részleg: szabadtéri fűtött medence, ((1mai.-30. sept) )jakuzzi, szauna heverőkkel, sós kamra és szabadtéri fűtött sós dézsa\r\n\r\n– Félpanziós ellátás\r\n\r\n– Grillező\r\n\r\n– Tágas filagória\r\n\r\n– Wifi internet hozzáférés\r\n\r\n– kábel TV\r\n\r\n– közös konyha és ebédlő\r\n\r\n– zárt, kamerával megfigyelt parkoló\r\n\r\n– Mini foci pálya\r\n\r\n– Biciklilk\r\n\r\n– Biliard asztal (fizetés ellenében), darts\r\n\r\n– Játszotér\r\n\r\nA medence május 1-től szeptember végéig működik.', '[\"HUN\",\"ROM\",\"ENG\"]', 15, 15, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Németh Recepció', 'kenyereszsolt920210+nemeth@gmail.com', '+40726185563', 'pensiuneanemeth.ro', 1646582153, 1),
(54, 'Molnos Kúria', 'Korond', 'molnos-kuria-korond', '{\"postalCode\":\"\",\"street\":\"F\\u0151\",\"number\":\"760\",\"building\":\"\",\"floor\":\"\",\"door\":\"\"}', 'PNS', 315, 12, 'Tér, csend, nyugalom,kényeztetés, idő, varázs, kényelem. Kúriánkban lelassul az idő, kitágul a tér, honol a csend.\r\n\r\nVarázslatos kilátással ébredhetsz, kényelmes, tágas tereinkben társaloghatsz, a tűz ropogása mellett vagy épp a fűtött sós jakuzziban kényeztetheted kedvesedet. Nálunk mindezt nem zavarja meg kéretlen gyermekzsivaj, felnőttbarát módon képzeljük el szállásunkat.\r\n\r\nBőséges, helyi termelőktől beszerzett hagyományos svédasztalos reggeli után gyönyörű kilátású teraszunkon tervezheted meg a napodat a gőzölgő tea vagy kávé mellett. Számos túrát tudunk ajánlani amik kiscsoportosan, szakavatott idegenvezetővel fedezik fel Korond, Sóvidék és Székelyföld csodás természeti és emberi értékeit (keresd a csomagajánlatainkat).', '[\"HUN\",\"ROM\",\"ENG\",\"GER\"]', 6, 6, '[\"MEA\",\"INT\",\"PRK\",\"HEA\",\"WEL\"]', 'Molnos Recepció', 'kenyereszsolt920210+molnos@gmail.com', '+40726185563', '', 1646582165, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `accm_discounts`
--

CREATE TABLE `accm_discounts` (
  `accm_id` int(11) NOT NULL,
  `children_discount` varchar(255) DEFAULT NULL,
  `children_discount_percent` int(11) DEFAULT NULL,
  `children_discount_for_accm` varchar(255) DEFAULT NULL,
  `children_discount_for_meals` varchar(255) DEFAULT NULL,
  `children_discount_for_wellness` varchar(255) DEFAULT NULL,
  `group_discount` varchar(255) DEFAULT NULL,
  `group_discount_percent` int(11) DEFAULT NULL,
  `group_person_number` int(11) DEFAULT NULL,
  `early_booking_discount` varchar(255) DEFAULT NULL,
  `early_booking_discount_percent` int(11) DEFAULT NULL,
  `early_booking_days` int(11) DEFAULT NULL,
  `last_minute_discount` varchar(255) DEFAULT NULL,
  `last_minute_discount_percent` int(11) DEFAULT NULL,
  `last_minute_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `accm_discounts`
--

INSERT INTO `accm_discounts` (`accm_id`, `children_discount`, `children_discount_percent`, `children_discount_for_accm`, `children_discount_for_meals`, `children_discount_for_wellness`, `group_discount`, `group_discount_percent`, `group_person_number`, `early_booking_discount`, `early_booking_discount_percent`, `early_booking_days`, `last_minute_discount`, `last_minute_discount_percent`, `last_minute_days`) VALUES
(1, 'YES', 50, 'YES', 'YES', NULL, 'YES', 10, 20, 'YES', 5, 20, 'YES', 3, 5),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 20, 30, 'YES', 15, 3),
(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 10, 2),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, NULL, NULL, NULL, NULL, NULL, 'YES', 10, 10, NULL, NULL, NULL, NULL, NULL, NULL),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 10, 2),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 10, 2),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 8, 45, NULL, NULL, NULL),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 30, 120, NULL, NULL, NULL),
(48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'YES', 10, 90, NULL, NULL, NULL),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `accm_images`
--

CREATE TABLE `accm_images` (
  `id` int(11) NOT NULL,
  `accm_id` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `uploaded` int(11) DEFAULT NULL,
  `is_primary` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `accm_images`
--

INSERT INTO `accm_images` (`id`, `accm_id`, `path`, `uploaded`, `is_primary`) VALUES
(5, 1, 'public/uploads/hotel-szeifert-szovata-800x416.jpg', 1642699298, 'YES'),
(6, 1, 'public/uploads/hotel-szeifert-szovata-2-800x515.jpg', 1642699298, NULL),
(9, 2, 'public/uploads/csatari-panzio-es-etterem-parajd-676x439.jpg', 1642784638, 'YES'),
(10, 4, 'public/uploads/septimia-resort-hotel-wellness-spa-szekelyudvarhely-676x439.jpg', 1642784735, 'YES'),
(15, 9, 'public/uploads/lobogo-resort-homorodfurdo-676x439.jpg', 1642785304, 'YES'),
(16, 10, 'public/uploads/hotel-o3zone-tusnadfurdo-676x439.jpg', 1642785408, 'YES'),
(17, 11, 'public/uploads/hetvezer-panzio-zetevaralja-800x600.jpg', 1642785434, 'YES'),
(18, 12, 'public/uploads/sugo-panzio-ivo-676x439.jpg', 1642785465, 'YES'),
(19, 13, 'public/uploads/eniko-kulcsoshaz-guductelep-676x439.jpg', 1642785521, 'YES'),
(20, 14, 'public/uploads/pava-panzio-wellness-szekelyudvarhely-676x439.jpg', 1642785541, 'YES'),
(21, 15, 'public/uploads/tip-top-panzio-kalotaszentkiraly-676x439.jpg', 1642785576, 'YES'),
(22, 16, 'public/uploads/szentkiraly-panzio-kalotaszentkiraly-676x439.jpg', 1642785612, 'YES'),
(23, 22, 'public/uploads/rossmarkt-haus-brasso-676x439.jpg', 1642785635, 'YES'),
(24, 23, 'public/uploads/lilla-apartmanok-szekelyudvarhely-676x439.jpg', 1642785681, 'YES'),
(25, 24, 'public/uploads/piricske-pihenohaz-piricske-50-800x535.jpg', 1642838803, 'YES'),
(26, 25, 'public/uploads/csango-fatanyeros-panziok-hidegseg-676x439.jpg', 1642838835, 'YES'),
(27, 26, 'public/uploads/anda-panzio-gyergyoszentmiklos-676x439.jpg', 1642838884, 'YES'),
(28, 27, 'public/uploads/dr-demeter-bela-vendeghaz-torocko-676x439.jpg', 1642838914, 'YES'),
(29, 28, 'public/uploads/dulo-annamaria-vendeghaz-torocko-676x439.jpg', 1642838943, 'YES'),
(30, 1, 'public/uploads/hotel-szeifert-szovata-16-800x535.jpg', 1642840058, NULL),
(31, 1, 'public/uploads/hotel-szeifert-szovata-15-800x489.jpg', 1642840058, NULL),
(32, 1, 'public/uploads/hotel-szeifert-szovata-14-800x489.jpg', 1642840058, NULL),
(33, 1, 'public/uploads/hotel-szeifert-szovata-13-800x525.jpg', 1642840058, NULL),
(34, 1, 'public/uploads/hotel-szeifert-szovata-12-800x535.jpg', 1642840058, NULL),
(35, 1, 'public/uploads/hotel-szeifert-szovata-11-800x489.jpg', 1642840058, NULL),
(36, 1, 'public/uploads/hotel-szeifert-szovata-10-800x510.jpg', 1642840058, NULL),
(37, 1, 'public/uploads/hotel-szeifert-szovata-9-800x489.jpg', 1642840058, NULL),
(38, 1, 'public/uploads/hotel-szeifert-szovata-7-800x535.jpg', 1642840058, NULL),
(39, 1, 'public/uploads/hotel-szeifert-szovata-6-800x535.jpg', 1642840058, NULL),
(40, 1, 'public/uploads/hotel-szeifert-szovata-4-800x529.jpg', 1642840058, NULL),
(41, 1, 'public/uploads/hotel-szeifert-szovata-3-800x500.jpg', 1642840058, NULL),
(42, 34, 'public/uploads/daniel-kastelyszallo-olasztelek-676x439.jpg', 1642840671, 'YES'),
(43, 35, 'public/uploads/wooden-attic-suite-brasso-676x439.jpg', 1642840692, 'YES'),
(44, 36, 'public/uploads/hunnia-huntanya-szentegyhaza-676x439.jpg', 1642840716, 'YES'),
(45, 37, 'public/uploads/cheminee-apartman-select-city-center-apartments-brasso-676x439.jpg', 1642840735, 'YES'),
(46, 38, 'public/uploads/cluj-aparthotel-kolozsvar-676x439.jpg', 1642840752, 'YES'),
(47, 39, 'public/uploads/viscri-195-panzio-adults-only-14-feheregyhaza-5-800x534.jpg', 1642840777, 'YES'),
(48, 40, 'public/uploads/haller-kastelyszallo-marosugra-676x439.jpg', 1642840798, 'YES'),
(49, 41, 'public/uploads/versay-hotel-herkulesfurdo-676x439.jpg', 1642840820, 'YES'),
(50, 42, 'public/uploads/ambient-hotel-brasso-676x439.jpg', 1642840973, 'YES'),
(51, 43, 'public/uploads/ensana-sovata-szovata-676x439.jpg', 1642840997, 'YES'),
(52, 44, 'public/uploads/harmonia-mundi-magyarfenes-676x439.jpg', 1642841024, 'YES'),
(53, 48, 'public/uploads/oasis-rural-kulcsoshaz-cegotelke-676x439.jpg', 1642841043, 'YES'),
(54, 49, 'public/uploads/casa-bertha-panzio-segesvar-676x439.jpg', 1642841061, 'YES'),
(55, 50, 'public/uploads/hillside-haven-kulcsoshaz-parajd-676x439.jpg', 1642841079, 'YES'),
(56, 51, 'public/uploads/veranda-panzio-es-etterem-gyergyoremete-676x439.jpg', 1642841097, 'YES'),
(57, 52, 'public/uploads/nadas-panzio-szek-676x439.jpg', 1642841121, 'YES'),
(58, 53, 'public/uploads/nemeth-panzio-szovata-676x439.jpg', 1642841138, 'YES'),
(59, 54, 'public/uploads/molnos-kuria-panzio-korond-676x439.jpg', 1642841157, 'YES');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `accm_meals`
--

CREATE TABLE `accm_meals` (
  `accm_id` int(11) NOT NULL,
  `meal_offered` varchar(255) DEFAULT NULL,
  `breakfast` varchar(255) DEFAULT NULL,
  `breakfast_price` int(11) DEFAULT NULL,
  `lunch` varchar(255) DEFAULT NULL,
  `lunch_price` int(11) DEFAULT NULL,
  `dinner` varchar(255) DEFAULT NULL,
  `dinner_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `accm_meals`
--

INSERT INTO `accm_meals` (`accm_id`, `meal_offered`, `breakfast`, `breakfast_price`, `lunch`, `lunch_price`, `dinner`, `dinner_price`) VALUES
(1, 'YES', 'INPRICE', NULL, 'ALACARTE', NULL, 'PAYABLE', 80),
(2, 'YES', 'PAYABLE', 25, 'NOTPROVIDED', NULL, 'PAYABLE', 30),
(4, 'YES', 'INPRICE', NULL, 'PAYABLE', 50, 'PAYABLE', 55),
(9, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'INPRICE', NULL),
(10, 'YES', 'INPRICE', NULL, 'PAYABLE', 60, 'INPRICE', NULL),
(11, 'YES', 'PAYABLE', 32, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(12, 'YES', 'NOTPROVIDED', NULL, 'ALACARTE', NULL, 'ALACARTE', NULL),
(13, 'NO', 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(14, 'NO', 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(15, 'YES', 'PAYABLE', 25, 'PAYABLE', 45, 'PAYABLE', 45),
(16, 'YES', 'PAYABLE', 25, 'NOTPROVIDED', NULL, 'PAYABLE', 45),
(22, 'NO', 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(23, 'NO', 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'YES', 'INPRICE', NULL, 'ALACARTE', NULL, 'ALACARTE', NULL),
(26, 'YES', 'PAYABLE', 30, 'PAYABLE', 60, 'PAYABLE', 60),
(27, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'INPRICE', NULL),
(28, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'INPRICE', NULL),
(34, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'PAYABLE', 50),
(40, 'YES', 'INPRICE', NULL, 'ALACARTE', NULL, 'ALACARTE', NULL),
(41, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'PAYABLE', 70),
(42, 'YES', 'INPRICE', NULL, 'PAYABLE', 84, 'PAYABLE', 84),
(43, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(44, 'YES', 'INPRICE', NULL, 'PAYABLE', 55, 'PAYABLE', 65),
(48, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'YES', 'PAYABLE', 25, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'YES', 'PAYABLE', 25, 'ALACARTE', NULL, 'ALACARTE', NULL),
(52, 'YES', 'PAYABLE', 25, 'PAYABLE', 45, 'PAYABLE', 30),
(53, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'PAYABLE', 50),
(54, 'YES', 'INPRICE', NULL, 'NOTPROVIDED', NULL, 'NOTPROVIDED', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `accm_types`
--

CREATE TABLE `accm_types` (
  `type_code` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `accm_types`
--

INSERT INTO `accm_types` (`type_code`, `name`) VALUES
('APT', 'Apartman'),
('CHA', 'Kulcsosház'),
('CMP', 'Kemping'),
('GHS', 'Vendégház'),
('HOT', 'Hotel'),
('HST', 'Hosztel'),
('MOT', 'Motel'),
('PNS', 'Panzió'),
('VAC', 'Nyaraló'),
('VIL', 'Villa');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `accm_units`
--

CREATE TABLE `accm_units` (
  `id` int(11) NOT NULL,
  `accm_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `unit_type` varchar(255) DEFAULT NULL,
  `rooms_count` int(11) DEFAULT NULL,
  `bed_types` varchar(255) DEFAULT NULL,
  `bathroom_type` varchar(255) DEFAULT NULL,
  `bathrooms_count` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `capacity_per_unit` int(11) DEFAULT NULL,
  `total_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `accm_units`
--

INSERT INTO `accm_units` (`id`, `accm_id`, `name`, `unit_type`, `rooms_count`, `bed_types`, `bathroom_type`, `bathrooms_count`, `price`, `count`, `capacity_per_unit`, `total_capacity`) VALUES
(8, 1, 'Franciaágyas földszinti szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 240, 2, 2, 4),
(9, 1, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 260, 3, 2, 6),
(10, 1, '2 fős Manzárd emeleti szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 260, 2, 2, 4),
(11, 1, '3 fős földszinti szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"1\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 280, 3, 3, 9),
(12, 1, '3 fős franciaágyas földszinti szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"1\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 280, 3, 3, 9),
(13, 1, 'Franciaágyas emeleti szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 285, 2, 2, 4),
(14, 1, 'Franciaágyas tóra néző szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 310, 1, 2, 2),
(15, 1, 'Art tóra néző szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 310, 1, 2, 2),
(16, 1, 'Franciaágyas szoba légkondicionálással', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 320, 2, 2, 4),
(17, 1, '3 fős emeleti szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"1\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 325, 3, 3, 9),
(18, 1, '3 fős franciaágyas emeleti szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"1\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 325, 3, 3, 9),
(19, 1, '3 fős franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"1\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 325, 3, 3, 9),
(20, 1, 'Romantic tóra néző szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 340, 1, 2, 2),
(21, 1, '2 fős tóra néző szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 340, 1, 2, 2),
(22, 1, '3 fős emeleti szoba légkondicionálással', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"1\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 350, 3, 3, 9),
(23, 1, 'Business apartman erkéllyel', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 380, 1, 4, 4),
(24, 1, '4 fős Manzárd emeleti apartman', 'apartment', 2, '{\"SINGLE\":\"2\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 380, 1, 4, 4),
(25, 1, '4 fős tetőtéri apartman erkéllyel', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 380, 1, 4, 4),
(26, 1, '4 fős Standard tetőtéri apartman', 'apartment', 1, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 380, 1, 4, 4),
(27, 1, 'Presidential tóra néző apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 400, 1, 4, 4),
(28, 1, '6 fős Manzárd lakosztály galériával', 'apartment', 3, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"2\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 430, 1, 6, 6),
(29, 1, '8 fős Manzárd lakosztály galériával', 'apartment', 4, '{\"SINGLE\":\"2\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"2\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 500, 1, 8, 8),
(30, 2, '1 fős szoba', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 110, 2, 1, 2),
(31, 2, 'Franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 140, 5, 2, 10),
(32, 2, '3 fős szoba', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 150, 1, 3, 3),
(33, 2, '4 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 160, 2, 4, 8),
(34, 2, '2 szobás faház', 'apartment', 2, '{\"SINGLE\":\"4\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 170, 1, 4, 4),
(35, 2, '4 fős faház', 'apartment', 1, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 180, 4, 4, 16),
(36, 2, '2 szobás apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 200, 2, 4, 8),
(37, 4, '2 fős Standard szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 520, 6, 2, 12),
(38, 4, '2 fős Superior szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 565, 13, 2, 26),
(39, 4, '2 fős Twin szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 565, 6, 2, 12),
(40, 4, 'Standard lakosztály', 'apartment', 1, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 1040, 2, 4, 8),
(41, 4, 'Junior lakosztály', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"1\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 2, 1220, 1, 3, 3),
(42, 4, 'Superior lakosztály', 'apartment', 1, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"1\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 1165, 5, 3, 15),
(43, 9, 'Standard szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 600, 2, 2, 4),
(44, 13, 'Teljes Kulcsosház', 'complete', 5, '{\"SINGLE\":\"17\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', NULL, 2, 650, 1, 17, 17),
(45, 10, '2 fős franciaágyas hegyekre néző szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 610, 5, 2, 10),
(46, 10, '2 fős 2 ágyas szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 610, 5, 2, 10),
(47, 11, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 230, 2, 2, 4),
(48, 11, '3 fős szoba', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 315, 4, 3, 12),
(49, 11, '4 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"1\"}', 'OWN', NULL, 350, 2, 4, 8),
(50, 11, 'Teljes Panzió', 'complete', 8, '{\"SINGLE\":\"4\",\"DOUBLE\":\"8\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"2\"}', NULL, 8, 2500, 1, 24, 24),
(51, 12, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 275, 4, 2, 8),
(52, 12, '4 fős Family szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 550, 7, 4, 28),
(53, 12, '11 fős szoba', 'room', NULL, '{\"SINGLE\":\"11\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'COMMON', NULL, 550, 1, 11, 11),
(54, 12, '6 fős szoba', 'room', NULL, '{\"SINGLE\":\"6\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'COMMON', NULL, 600, 2, 6, 12),
(55, 14, '2 fős franciaágyas Standard szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 335, 9, 2, 18),
(56, 14, '2 fős Superior szoba erkéllyel', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 395, 4, 2, 8),
(57, 14, '4 fős apartman erkéllyel', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 580, 2, 4, 8),
(58, 15, 'Franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 120, 2, 2, 4),
(59, 15, '3 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"1\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'COMMON', NULL, 180, 1, 3, 3),
(60, 15, '3 fős szoba közös fürdőszobával', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'COMMON', NULL, 180, 1, 3, 3),
(61, 15, '4 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 240, 1, 4, 4),
(62, 15, '3 fős szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 270, 1, 3, 3),
(63, 15, 'Teljes Panzió', 'complete', 6, '{\"SINGLE\":\"2\",\"DOUBLE\":\"7\",\"SINGLECOUCH\":\"1\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', NULL, 4, 7500, 1, 17, 17),
(64, 16, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 200, 1, 2, 2),
(65, 16, '3 fős szoba', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 300, 4, 3, 12),
(66, 16, '4 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 400, 2, 4, 8),
(67, 16, 'Teljes Panzió', 'complete', 7, '{\"SINGLE\":\"4\",\"DOUBLE\":\"7\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"2\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', NULL, 3, 2000, 1, 22, 22),
(68, 22, '2 fős 2 ágyas tetőtéri szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 370, 1, 2, 2),
(69, 22, '3 fős szoba erkéllyel', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 420, 1, 3, 3),
(70, 22, '4 fős panorámás szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 450, 1, 4, 4),
(71, 22, '2 szobás panorámás apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 480, 1, 4, 4),
(72, 23, '2 szobás Family apartman', 'apartment', 2, '{\"SINGLE\":\"3\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 2, 455, 4, 5, 20),
(73, 24, 'Teljes Kulcsosház', 'complete', 5, '{\"SINGLE\":\"8\",\"DOUBLE\":\"3\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', NULL, 2, 1000, 1, 14, 14),
(74, 25, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 165, 4, 2, 8),
(75, 25, 'Franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 230, 2, 2, 4),
(76, 25, '4 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 345, 4, 4, 16),
(77, 26, '2 fős franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 140, 2, 2, 4),
(78, 26, '2 fős hegyekre néző szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 140, 6, 1, 6),
(79, 26, 'Franciaágyas hegyekre néző szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 140, 3, 2, 6),
(80, 26, '2 fős franciaágyas Lux szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 160, 1, 2, 2),
(81, 26, '4 fős franciaágyas apartman', 'apartment', 1, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'COMMON', 1, 320, 1, 4, 4),
(82, 26, '4 fős Deluxe szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 400, 1, 4, 4),
(83, 27, '2 ágyas szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 300, 6, 2, 12),
(84, 27, '3 ágyas szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"3\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 400, 4, 3, 12),
(85, 27, '4 fős Komfort szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 500, 4, 4, 16),
(86, 28, '2 ágyas szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 280, 3, 2, 6),
(87, 28, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 280, 1, 2, 2),
(88, 28, '3 fős szoba', 'room', NULL, '{\"SINGLE\":\"3\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 420, 1, 3, 3),
(89, 34, '2 fős egyszemélyes összetolható ágyas Standard szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 450, 10, 2, 20),
(90, 34, '2 fős franciaágyas Superior szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 600, 7, 2, 14),
(91, 34, '2 fős franciaágyas Deluxe szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 750, 3, 2, 6),
(92, 35, 'Deluxe tetőtéri lakosztály légkondiciónálással', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 270, 1, 6, 6),
(93, 36, '2 fős kertre néző szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 385, 1, 2, 2),
(94, 36, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 462, 1, 2, 2),
(95, 36, '2 fős panorámás szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 462, 1, 2, 2),
(96, 36, '4 fős udvarra néző szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 724, 1, 4, 4),
(97, 36, '4 fős franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 724, 1, 4, 4),
(98, 36, '4 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 724, 1, 4, 4),
(99, 36, '4 fős panorámás szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 724, 1, 4, 4),
(100, 37, '4 fős apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 325, 1, 4, 4),
(105, 38, '4 fős apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 270, 1, 4, 4),
(106, 38, '2 szobás apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 270, 1, 4, 4),
(107, 38, '4 fős King apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 270, 1, 4, 4),
(108, 39, '2 fős Tradicionális szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 250, 1, 2, 2),
(109, 39, '2 fős Komfort szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 250, 1, 2, 2),
(110, 39, 'Studio lakosztály fürdőszobával', 'apartment', 1, '{\"SINGLE\":\"3\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 300, 1, 3, 3),
(111, 39, '4 fős Manzárd szoba fürdőszobával', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 400, 1, 4, 4),
(112, 40, '2 fős 2 ágyas szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 340, 5, 2, 10),
(113, 40, '2 fős franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 340, 7, 2, 14),
(114, 40, '2 fős Deluxe szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 420, 1, 2, 2),
(115, 40, 'Apartman', 'apartment', 1, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"1\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 470, 1, 3, 3),
(116, 41, '1 fős szoba', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 320, 2, 1, 2),
(117, 41, '2 fős franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 450, 23, 2, 46),
(118, 41, '2 fős Family apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 550, 2, 4, 8),
(119, 42, '1 fős egyszemélyes nem összetolható ágyas Standard szoba', 'room', NULL, '{\"SINGLE\":\"1\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 406, 4, 1, 4),
(120, 42, '2 fős egyszemélyes összetolható ágyas Deluxe szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 427, 17, 2, 34),
(121, 42, '2 fős franciaágyas Business szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 524, 15, 2, 30),
(122, 42, '2 fős franciaágyas Deluxe szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 427, 17, 2, 34),
(123, 42, '3 fős lakosztály', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"1\",\"BUNKBED\":\"0\"}', 'OWN', 1, 757, 3, 3, 9),
(124, 43, '2 fős Standard szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 600, 10, 2, 20),
(125, 43, '2 fős Deluxe szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 760, 1, 2, 2),
(126, 43, '2 fős Deluxe tóra néző szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 810, 1, 2, 2),
(127, 44, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 350, 1, 2, 2),
(128, 44, '2 fős lakosztály', 'apartment', 1, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 380, 2, 2, 4),
(129, 44, '3 fős King szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"1\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 400, 1, 3, 3),
(130, 44, '4 fős apartman', 'apartment', 3, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 500, 1, 4, 4),
(131, 44, '5 fős Family lakosztály', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"1\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 550, 1, 5, 5),
(132, 44, 'Teljes Panzió', 'complete', 6, '{\"SINGLE\":\"0\",\"DOUBLE\":\"7\",\"SINGLECOUCH\":\"2\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', NULL, 6, 2040, 1, 18, 18),
(133, 48, 'Teljes Kulcsosház', 'complete', 3, '{\"SINGLE\":\"3\",\"DOUBLE\":\"3\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', NULL, 3, 750, 1, 9, 9),
(134, 49, '2 fős Komfort emeleti szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 400, 1, 2, 2),
(135, 49, '2 fős franciaágyas King szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 400, 1, 2, 2),
(136, 49, '2 fős 2 ágyas Deluxe szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 420, 1, 2, 2),
(137, 49, '2 fős franciaágyas emeleti apartman', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 450, 1, 2, 2),
(138, 50, 'Teljes Kulcsosház', 'complete', 4, '{\"SINGLE\":\"1\",\"DOUBLE\":\"2\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"1\",\"BUNKBED\":\"0\"}', NULL, 1, 750, 1, 8, 8),
(139, 51, '2 fős 2 ágyas szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 242, 4, 2, 8),
(140, 51, '2 fős emeleti szoba erkéllyel', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 242, 6, 2, 12),
(141, 51, 'Family szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"1\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 368, 3, 4, 12),
(142, 51, '4 fős 4 ágyas szoba', 'room', NULL, '{\"SINGLE\":\"4\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 385, 2, 4, 8),
(143, 52, '2 fős szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 170, 3, 2, 6),
(144, 52, '2 fős Twin szoba', 'room', NULL, '{\"SINGLE\":\"2\",\"DOUBLE\":\"0\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 170, 3, 2, 6),
(145, 52, 'Teljes Panzió', 'complete', 6, '{\"SINGLE\":\"6\",\"DOUBLE\":\"3\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', NULL, 6, 1200, 1, 12, 12),
(146, 53, '2 fős franciaágyas szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 280, 6, 2, 12),
(147, 53, '4 fős Family szoba erkéllyel', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"1\"}', 'OWN', NULL, 420, 7, 4, 28),
(148, 53, '3 fős Family apartman saját teakonyhával', 'apartment', 2, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"1\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', 1, 446, 2, 3, 6),
(149, 54, '2 fős franciaágyas Deluxe szoba', 'room', NULL, '{\"SINGLE\":\"0\",\"DOUBLE\":\"1\",\"SINGLECOUCH\":\"0\",\"DOUBLECOUCH\":\"0\",\"ARMCHAIR\":\"0\",\"BUNKBED\":\"0\"}', 'OWN', NULL, 700, 6, 2, 12);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `accm_wellness`
--

CREATE TABLE `accm_wellness` (
  `accm_id` int(11) NOT NULL,
  `wellness_offered` varchar(255) DEFAULT NULL,
  `pool` varchar(255) DEFAULT NULL,
  `sauna` varchar(255) DEFAULT NULL,
  `jacuzzi` varchar(255) DEFAULT NULL,
  `tub` varchar(255) DEFAULT NULL,
  `fitness` varchar(255) DEFAULT NULL,
  `wellness_status` varchar(255) DEFAULT NULL,
  `wellness_price` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `accm_wellness`
--

INSERT INTO `accm_wellness` (`accm_id`, `wellness_offered`, `pool`, `sauna`, `jacuzzi`, `tub`, `fitness`, `wellness_status`, `wellness_price`) VALUES
(1, 'YES', NULL, 'YES', 'YES', NULL, NULL, 'PAYABLE', '20'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'YES', 'YES', 'YES', 'YES', 'YES', 'YES', 'INPRICE', NULL),
(9, 'YES', 'YES', 'YES', 'YES', NULL, NULL, 'INPRICE', NULL),
(10, 'YES', 'YES', 'YES', NULL, NULL, NULL, 'INPRICE', NULL),
(11, 'YES', NULL, 'YES', NULL, 'YES', NULL, 'PAYABLE', '60'),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'YES', 'YES', 'YES', 'YES', NULL, NULL, 'INPRICE', NULL),
(15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'YES', NULL, NULL, NULL, 'YES', NULL, 'PAYABLE', '30'),
(25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'YES', NULL, 'YES', NULL, 'YES', NULL, 'PAYABLE', '500'),
(27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'YES', NULL, 'YES', 'YES', NULL, NULL, 'INPRICE', NULL),
(42, 'YES', 'YES', 'YES', NULL, NULL, 'YES', 'INPRICE', NULL),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'YES', NULL, 'YES', 'YES', 'YES', NULL, 'PAYABLE', '50'),
(48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'YES', NULL, 'YES', 'YES', NULL, NULL, 'PAYABLE', '30'),
(52, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'YES', NULL, 'YES', 'YES', 'YES', NULL, 'INPRICE', NULL),
(54, 'YES', NULL, 'YES', 'YES', 'YES', NULL, 'INPRICE', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `bed_types`
--

CREATE TABLE `bed_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `places` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `bed_types`
--

INSERT INTO `bed_types` (`id`, `name`, `value`, `places`) VALUES
(1, 'Egyszemélyes ágy', 'SINGLE', 1),
(2, 'Franciaágy', 'DOUBLE', 2),
(3, 'Kanapé', 'SINGLECOUCH', 1),
(4, 'Kanapé', 'DOUBLECOUCH', 2),
(5, 'Fotelágy', 'ARMCHAIR', 1),
(6, 'Emeletes ágy', 'BUNKBED', 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `sent_at` int(11) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `seen` tinyint(1) DEFAULT NULL,
  `seen_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `started_by_user_id` int(11) DEFAULT NULL,
  `started_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `conversation_users`
--

CREATE TABLE `conversation_users` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) DEFAULT NULL,
  `member_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `email_messages`
--

CREATE TABLE `email_messages` (
  `id` int(11) NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('notSent','sending','sent','') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_attempts` int(11) DEFAULT NULL,
  `sent_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `facility_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `facilities`
--

INSERT INTO `facilities` (`id`, `facility_code`, `name`) VALUES
(1, 'MEA', 'Étkezés'),
(2, 'INT', 'Internet'),
(3, 'PRK', 'Parkoló'),
(4, 'AIR', 'Légkondi'),
(5, 'HEA', 'Fűtés'),
(6, 'WEL', 'Wellness'),
(7, 'POL', 'Medence');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`) VALUES
(1, 'HUN', 'magyar'),
(2, 'ROM', 'román'),
(3, 'ENG', 'angol'),
(4, 'GER', 'német'),
(5, 'ITA', 'olasz'),
(6, 'FRA', 'francia'),
(7, 'ESP', 'spanyol');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `reserved` int(11) DEFAULT NULL,
  `adults` int(11) DEFAULT NULL,
  `children` int(11) DEFAULT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `nights` int(11) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `reserved_accm_id` int(11) DEFAULT NULL,
  `full_config` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `services`
--

INSERT INTO `services` (`id`, `name`, `value`, `category`) VALUES
(1, 'Reggeli', 'breakfast', 'meal'),
(2, 'Ebéd', 'lunch', 'meal'),
(3, 'Vacsora', 'dinner', 'meal'),
(4, 'medence', 'pool', 'wellness'),
(5, 'szauna', 'sauna', 'wellness'),
(6, 'jacuzzi', 'jacuzzi', 'wellness'),
(7, 'dézsa', 'tub', 'wellness'),
(8, 'fitnesz terem', 'fitness', 'wellness');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `services_status`
--

CREATE TABLE `services_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `services_status`
--

INSERT INTO `services_status` (`id`, `name`, `value`, `category`) VALUES
(1, 'Nincs', 'NOTPROVIDED', 'meal'),
(2, 'Benne van az árban', 'INPRICE', 'meal'),
(3, 'A la carte', 'ALACARTE', 'meal'),
(4, 'Fizetős', 'PAYABLE', 'meal'),
(5, 'Benne van az árban', 'INPRICE', 'wellness'),
(6, 'Fizetős', 'PAYABLE', 'wellness');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `registered` int(11) DEFAULT NULL,
  `last_modified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `accms`
--
ALTER TABLE `accms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accm_type` (`accm_type`);

--
-- A tábla indexei `accm_discounts`
--
ALTER TABLE `accm_discounts`
  ADD PRIMARY KEY (`accm_id`);

--
-- A tábla indexei `accm_images`
--
ALTER TABLE `accm_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accm_id` (`accm_id`);

--
-- A tábla indexei `accm_meals`
--
ALTER TABLE `accm_meals`
  ADD PRIMARY KEY (`accm_id`);

--
-- A tábla indexei `accm_types`
--
ALTER TABLE `accm_types`
  ADD PRIMARY KEY (`type_code`);

--
-- A tábla indexei `accm_units`
--
ALTER TABLE `accm_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accm_id` (`accm_id`);

--
-- A tábla indexei `accm_wellness`
--
ALTER TABLE `accm_wellness`
  ADD PRIMARY KEY (`accm_id`);

--
-- A tábla indexei `bed_types`
--
ALTER TABLE `bed_types`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `from_user_id` (`from_user_id`);

--
-- A tábla indexei `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `conversation_users`
--
ALTER TABLE `conversation_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `conversation_users_ibfk_2` (`member_user_id`);

--
-- A tábla indexei `email_messages`
--
ALTER TABLE `email_messages`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `services_status`
--
ALTER TABLE `services_status`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `accms`
--
ALTER TABLE `accms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT a táblához `accm_images`
--
ALTER TABLE `accm_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT a táblához `accm_units`
--
ALTER TABLE `accm_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT a táblához `bed_types`
--
ALTER TABLE `bed_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `conversation_users`
--
ALTER TABLE `conversation_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `email_messages`
--
ALTER TABLE `email_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `services_status`
--
ALTER TABLE `services_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `accm_discounts`
--
ALTER TABLE `accm_discounts`
  ADD CONSTRAINT `accm_discounts_ibfk_1` FOREIGN KEY (`accm_id`) REFERENCES `accms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `accm_images`
--
ALTER TABLE `accm_images`
  ADD CONSTRAINT `accm_images_ibfk_1` FOREIGN KEY (`accm_id`) REFERENCES `accms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `accm_meals`
--
ALTER TABLE `accm_meals`
  ADD CONSTRAINT `accm_meals_ibfk_1` FOREIGN KEY (`accm_id`) REFERENCES `accms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `accm_units`
--
ALTER TABLE `accm_units`
  ADD CONSTRAINT `accm_units_ibfk_1` FOREIGN KEY (`accm_id`) REFERENCES `accms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `accm_wellness`
--
ALTER TABLE `accm_wellness`
  ADD CONSTRAINT `accm_wellness_ibfk_1` FOREIGN KEY (`accm_id`) REFERENCES `accms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `conversation_users`
--
ALTER TABLE `conversation_users`
  ADD CONSTRAINT `conversation_users_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `conversation_users_ibfk_2` FOREIGN KEY (`member_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
