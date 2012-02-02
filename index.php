<html>
<head>
    <link rel="stylesheet" href="libraries/termlib/term_styles.css" type="text/css" media="screen" />

    <script type="text/javascript" src="libraries/jquery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="libraries/termlib/compacted/termlib_min.js"></script>
    <script type="text/javascript" src="libraries/termlib/compacted/termlib_parser_min.js"></script>
</head>
<body>

<script type="text/javascript">
    <!--

    // *** text color sample ***
    // mass:werk, N.Landsteiner 2007

    jQuery(function(){

        var term;

        var help = [
            '%+r termlib color sample help: %-r',
            '',
            ' * type "colors"    to see the default internal colors.',
            ' * type "webcolors" to see the standard VGA and web safe colors.',
            ' * type "nscolors"  to see the VGA and netscape colors by name.',
            ' * type "help"      to see this page.',
            ' * type "exit"      to quit.',
            ' '
        ];

        var colorTable = [
            'termlib.js internal color table:',
            ' %+i%+ucolor name   code        sample       comment%-i                                %-u',
            ' default        0     %c(default)normal %+rreverse%-r%c0   "default" refers always to config color',
            ' black          1     %c(black)normal %+rreverse%-r%c0',
            ' red            2     %c(red)normal %+rreverse%-r%c0',
            ' green          3     %c(green)normal %+rreverse%-r%c0',
            ' yellow         4     %c(yellow)normal %+rreverse%-r%c0',
            ' blue           5     %c(blue)normal %+rreverse%-r%c0',
            ' magenta        6     %c(magenta)normal %+rreverse%-r%c0',
            ' cyan           7     %c(cyan)normal %+rreverse%-r%c0',
            ' white          8     %c(white)normal %+rreverse%-r%c0',
            ' grey           9     %c(grey)normal %+rreverse%-r%c0',
            ' darkred        A     %c(darkred)normal %+rreverse%-r%c0   hex 10',
            ' darkgreen      B     %c(darkgreen)normal %+rreverse%-r%c0   hex 11',
            ' darkyellow     C     %c(darkyellow)normal %+rreverse%-r%c0   hex 12',
            ' darkblue       D     %c(darkblue)normal %+rreverse%-r%c0   hex 13',
            ' darkmagenta    E     %c(darkmagenta)normal %+rreverse%-r%c0   hex 14',
            ' darkcyan       F     %c(darkcyan)normal %+rreverse%-r%c0   hex 15',
            ' ',
            '%+i(type "nscolors" or "webcolors" for some more supported color sets.)%-i'
        ];

        function listNetsacpeColors() {
            var t=new Array();
            for (var k in TermGlobals.nsColors) t.push(k);
            t.sort();
            var s='%+usupported Netscape colors by name:%-u\n\n';
            var l=0;
            for (var i=0; i<t.length; i++) {
                var c=t[i];
                if (l+c.length>78) {
                    s+='\n';
                    l=0;
                }
                else if (l>0) {
                    s+=' ';
                    l++;
                }
                s+= '%c(@'+c+')'+c;
                l+=c.length;
            }
            return s+'%c0\n ';
        }

        function listWebColors() {
            var t=new Array();
            for (var k=1; k<TermGlobals.webColorCodes.length; k++) {
                t.push(TermGlobals.webColorCodes[k]);
            }
            var s='%+usupported 216 web colors:%-u (you may use 3 digit codes also)\n\n';
            var l=0;
            for (var i=0; i<t.length; i++) {
                var c=t[i];
                if (l+c.length>78) {
                    s+='\n';
                    l=0;
                }
                else if (l>0) {
                    s+=' ';
                    l++;
                }
                s+= '%c(#'+c+')'+c;
                l+=c.length;
            }
            return s+'%c0\n ';
        }

        if ((!term) || (term.closed)) {
            term = new Terminal(
                {
                    crsrBlinkMode: true,
                    cols: 300,
                    rows: 10,
                    x: 0,
                    y: 0,
                    termDiv: 'termDiv',
                    bgColor: '#232e45',
                    initHandler: termInitHandler,
                    handler: termHandler,
                    exitHandler: termExitHandler
                }
            );
            term.open();
            // dimm UI text
            var mainPane = (document.getElementById)?
                document.getElementById('mainPane') : document.all.mainPane;
            if (mainPane) mainPane.className = 'lh15 dimmed';

            // instantiate Parser
            parser = new Parser();
        }

        function termExitHandler() {
            // reset the UI
            var mainPane = (document.getElementById)?
                document.getElementById('mainPane') : document.all.mainPane;
            if (mainPane) mainPane.className = 'lh15';
        }

        function termInitHandler() {
            // output a start up screen
            this.write(
                [
                    '%c(@turquoise)            ****           Man-Servant at your service!            ****',
                    '%c()%n'
                ]
            );
            this.write(colorTable);
            // and leave with prompt
            this.prompt();
        }

        function termHandler() {
            // default handler + exit
            this.newLine();

            parser.parseLine(this);
            if (this.argv.length == 0) {
                // no commmand line input
            }
            else
            {
                var cmd = this.argv[this.argc++]; // we advance argc to point to the next chunk
                cmd = cmd.toLowerCase();          // case insensitive (dumb shell)

                switch (cmd) {
                    case "ls":
                        var opts = parser.getopt(this, "prt");
                        console.log(opts);
                        console.log(this.argv[this.argc++])

                        var opts = parser.getopt(this, "prt");
                        console.log(opts);
                        console.log(this.argv[this.argc++])

                        var opts = parser.getopt(this, "prt");
                        console.log(opts);


                        console.log(this.argc)
                        console.log(this.argv)

                        if (opts.illegals.length) {
                            // other option flags found
                            this.write("Error: Illegal option.");
                        }
                        else if (this.argc != this.argv.length-2) {
                            this.write("Error: Illegal argument list.");
                        }
                        else
                        {
                            this.type(this.argv[this.argc])
                        }
                    break;
                    case "exit":
                        this.close();
                        return;
                    break;
                    case "exit":
                        this.close();
                        return;
                    break;
                    case "clear":
                        this.clear();
                    break;
                }
            }

            this.prompt();
        }

    });
    //-->
</script>


<div id="termDiv" style="position:absolute; visibility: hidden; z-index:1;"></div>

</body>
</html>