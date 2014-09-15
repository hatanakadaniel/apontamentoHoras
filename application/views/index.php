    <?php
        $this->load->view('header');
        $this->load->view('includeCSS');
    ?>
    </head>
    <body>
        <input type="hidden" name="base_url" value="<?php echo base_url(); ?>">
        <section>
            <header>
                <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle btn btn-primary navbar-btn" data-toggle="collapse" data-target="#teste">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="<?php echo base_url(); ?>"><span class="logo"></span></a>
                        </div>
                        <div class="collapse navbar-collapse" id="teste">
                            <ul class="nav navbar-nav">
                                <?php foreach ($menu as $itemMenu) : ?>
                                <li class="<?php echo $itemMenu->getActive()?'active':''; ?>">
                                    <a href="<?php echo $itemMenu->getLink(); ?>"><?php echo $itemMenu->getName(); ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <section id="content">
                <?php $this->load->view($view); ?>
            </section>
        </section>
        <?php
            $this->load->view('includeJS');
        ?>
    </body>
    <?php
        $this->load->view('footer');