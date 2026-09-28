/* Laravel UI AI Kit — landing page behaviour. Copy-to-clipboard and smooth anchors. */

(function () {
    'use strict';

    function initHeroScene() {
        var canvas = document.querySelector('[data-uiaikit-hero-canvas]');
        var stage = document.querySelector('[data-uiaikit-hero-stage]');

        if (!canvas || !stage || !window.THREE) return;

        var THREE = window.THREE;
        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(32, 1, 0.1, 100);
        camera.position.set(0, 0, 6.8);

        var renderer;
        try {
            renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true, preserveDrawingBuffer: true, powerPreference: 'low-power' });
        } catch (error) {
            return;
        }

        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.8));
        renderer.outputColorSpace = THREE.SRGBColorSpace;
        renderer.setClearColor(0x000000, 0);
        scene.add(new THREE.HemisphereLight(0xfff1df, 0x4c555d, 2.1));

        var keyLight = new THREE.DirectionalLight(0xffffff, 2.5);
        keyLight.position.set(-3, 4, 5);
        scene.add(keyLight);

        var mintLight = new THREE.DirectionalLight(0x8ee2d0, 1.1);
        mintLight.position.set(4, -1, 3);
        scene.add(mintLight);

        var mascot = new THREE.Group();
        scene.add(mascot);

        var coralMaterial = new THREE.MeshPhysicalMaterial({ color: 0xf34d35, roughness: 0.34, clearcoat: 0.36, clearcoatRoughness: 0.22 });
        var earMaterial = new THREE.MeshPhysicalMaterial({ color: 0xff795e, roughness: 0.4, clearcoat: 0.2 });
        var darkMaterial = new THREE.MeshStandardMaterial({ color: 0x30232c, roughness: 0.28 });
        var creamMaterial = new THREE.MeshBasicMaterial({ color: 0xfff7e9 });
        var cheekMaterial = new THREE.MeshBasicMaterial({ color: 0xffa49a, transparent: true, opacity: 0.8 });
        var body = new THREE.Mesh(new THREE.SphereGeometry(1, 48, 40), coralMaterial);
        body.scale.set(1, 0.94, 0.76);
        body.position.y = -0.08;
        mascot.add(body);

        [-1, 1].forEach(function (side) {
            var ear = new THREE.Mesh(new THREE.SphereGeometry(0.28, 24, 20), earMaterial);
            ear.scale.set(0.8, 1.05, 0.75);
            ear.position.set(side * 0.67, 0.68, 0.02);
            mascot.add(ear);

            var eye = new THREE.Mesh(new THREE.SphereGeometry(0.085, 20, 16), darkMaterial);
            eye.position.set(side * 0.29, 0.1, 0.68);
            mascot.add(eye);

            var eyeGlint = new THREE.Mesh(new THREE.SphereGeometry(0.026, 12, 10), creamMaterial);
            eyeGlint.position.set(side * 0.29 - 0.022, 0.13, 0.747);
            mascot.add(eyeGlint);

            var cheek = new THREE.Mesh(new THREE.SphereGeometry(0.115, 20, 16), cheekMaterial);
            cheek.position.set(side * 0.51, -0.17, 0.57);
            mascot.add(cheek);

            var arm = new THREE.Mesh(new THREE.SphereGeometry(0.25, 24, 18), coralMaterial);
            arm.scale.set(0.8, 1.05, 0.82);
            arm.position.set(side * 0.96, -0.34, 0.04);
            arm.rotation.z = side * -0.42;
            mascot.add(arm);
        });

        var smileCurve = new THREE.CatmullRomCurve3([
            new THREE.Vector3(-0.13, -0.23, 0.69),
            new THREE.Vector3(0, -0.32, 0.75),
            new THREE.Vector3(0.13, -0.23, 0.69)
        ]);
        mascot.add(new THREE.Mesh(new THREE.TubeGeometry(smileCurve, 18, 0.022, 8, false), darkMaterial));

        var orbit = new THREE.Mesh(
            new THREE.TorusGeometry(1.62, 0.018, 8, 96),
            new THREE.MeshStandardMaterial({ color: 0x65cbb7, metalness: 0.2, roughness: 0.38 })
        );
        orbit.rotation.set(1.13, 0.2, -0.28);
        mascot.add(orbit);

        var star = new THREE.Mesh(
            new THREE.OctahedronGeometry(0.14, 0),
            new THREE.MeshStandardMaterial({ color: 0xffcb59, roughness: 0.34, metalness: 0.08 })
        );
        star.position.set(-1.34, 1.02, 0.45);
        mascot.add(star);

        var sparkle = new THREE.Mesh(
            new THREE.IcosahedronGeometry(0.1, 0),
            new THREE.MeshStandardMaterial({ color: 0x83d9c4, roughness: 0.35 })
        );
        sparkle.position.set(1.42, -0.78, 0.5);
        mascot.add(sparkle);

        var targetRotation = { x: 0, y: 0 };
        var resize = function () {
            var width = Math.max(stage.clientWidth, 1);
            var height = Math.max(stage.clientHeight, 1);
            renderer.setSize(width, height, false);
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.render(scene, camera);
        };

        stage.addEventListener('pointermove', function (event) {
            var bounds = stage.getBoundingClientRect();
            targetRotation.y = ((event.clientX - bounds.left) / bounds.width - 0.5) * 0.38;
            targetRotation.x = ((event.clientY - bounds.top) / bounds.height - 0.5) * -0.2;
        });

        if (typeof ResizeObserver !== 'undefined') {
            new ResizeObserver(resize).observe(stage);
        } else {
            window.addEventListener('resize', resize);
        }

        resize();
        stage.setAttribute('data-scene-ready', 'true');

        if (!reducedMotion) {
            var animate = function (time) {
                if (document.hidden) return;
                mascot.position.y = Math.sin(time * 0.0009) * 0.09;
                mascot.rotation.y += (targetRotation.y - mascot.rotation.y) * 0.035;
                mascot.rotation.x += (targetRotation.x - mascot.rotation.x) * 0.035;
                orbit.rotation.z = -0.28 + Math.sin(time * 0.00035) * 0.08;
                star.rotation.y = time * 0.00045;
                sparkle.rotation.x = time * 0.0004;
                renderer.render(scene, camera);
                window.requestAnimationFrame(animate);
            };

            window.requestAnimationFrame(animate);
        }
    }

    function loadHeroScene() {
        var stage = document.querySelector('[data-uiaikit-hero-stage]');
        if (!stage) return;

        var startScene = function () {
            if (window.THREE) initHeroScene();
        };

        var loadThree = function () {
            if (window.THREE) {
                startScene();
                return;
            }

            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/0.160.0/three.min.js';
            script.async = true;
            script.onload = startScene;
            script.onerror = function () {
                stage.setAttribute('data-scene-fallback', 'true');
            };
            document.head.appendChild(script);
        };

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                if (entries.some(function (entry) { return entry.isIntersecting; })) {
                    observer.disconnect();
                    loadThree();
                }
            }, { rootMargin: '180px' });
            observer.observe(stage);
            return;
        }

        loadThree();
    }

    function init() {
        loadHeroScene();

        var themeToggle = document.querySelector('[data-uiaikit-theme-toggle]');

        if (themeToggle) {
            var themeKey = 'ui-ai-kit-theme';
            var setTheme = function (theme) {
                document.body.setAttribute('data-uiaikit-theme', theme);
                document.querySelectorAll('.uiaikit-chat').forEach(function (chat) {
                    chat.setAttribute('data-uiaikit-theme', theme);
                });
                var nextTheme = theme === 'dark' ? 'light' : 'dark';
                themeToggle.setAttribute('aria-label', 'Switch to ' + nextTheme + ' mode');
                themeToggle.setAttribute('title', 'Switch to ' + nextTheme + ' mode');
                themeToggle.querySelector('[data-uiaikit-theme-label]').textContent = 'Switch to ' + nextTheme + ' mode';
            };

            try {
                var savedTheme = window.localStorage.getItem(themeKey);
                if (savedTheme === 'light' || savedTheme === 'dark') setTheme(savedTheme);
            } catch (error) {
                // Keep the configured theme when browser storage is unavailable.
            }

            themeToggle.addEventListener('click', function () {
                var nextTheme = document.body.getAttribute('data-uiaikit-theme') === 'dark' ? 'light' : 'dark';
                setTheme(nextTheme);
                try {
                    window.localStorage.setItem(themeKey, nextTheme);
                } catch (error) {
                    // The toggle still works for this page view without storage.
                }
            });
        }

        document.querySelectorAll('[data-uiaikit-copy]').forEach(function (button) {
            button.addEventListener('click', function () {
                var value = button.getAttribute('data-uiaikit-copy') || '';
                var done = function () {
                    var original = button.textContent;
                    button.textContent = 'Copied';
                    setTimeout(function () {
                        button.textContent = original;
                    }, 1600);
                };

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(value).then(done);
                    return;
                }

                var field = document.createElement('textarea');
                field.value = value;
                field.setAttribute('readonly', '');
                field.style.position = 'absolute';
                field.style.left = '-9999px';
                document.body.appendChild(field);
                field.select();
                try {
                    document.execCommand('copy');
                    done();
                } finally {
                    field.remove();
                }
            });
        });

        document.querySelectorAll('[data-uiaikit-conversion]').forEach(function (link) {
            link.addEventListener('click', function () {
                var destination = new URL(link.href);
                document.dispatchEvent(new CustomEvent('uiaikit:conversion', {
                    detail: {
                        placement: link.getAttribute('data-uiaikit-conversion'),
                        label: link.textContent.trim(),
                        destination: destination.origin + destination.pathname
                    }
                }));
            });
        });

        document.querySelectorAll('[data-uiaikit-lead-form]').forEach(function (form) {
            form.addEventListener('submit', function () {
                document.dispatchEvent(new CustomEvent('uiaikit:lead-submit', {
                    detail: { method: form.method.toUpperCase() }
                }));
            });
        });

        document.querySelectorAll('.uiaikit a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (event) {
                var target = document.querySelector(anchor.getAttribute('href'));
                if (!target) return;
                event.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                target.setAttribute('tabindex', '-1');
                target.focus({ preventScroll: true });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
