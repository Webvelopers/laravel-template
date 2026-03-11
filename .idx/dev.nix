{pkgs}: {
  channel = "stable-24.05";
  packages = [
    pkgs.php83
    pkgs.php83Packages.composer
    pkgs.nodejs_22
  ];
  env = {};
  idx = {
    extensions = [
      "amirmarmul.laravel-blade-vscode"
      "bmewburn.vscode-intelephense-client"
      "bradlc.vscode-tailwindcss"
      "esbenp.prettier-vscode"
      "laravel.vscode-laravel"
      "porifa.laravel-intelephense"
      "streetsidesoftware.code-spell-checker"
      "usernamehw.errorlens"
      "yy0931.vscode-sqlite3-editor"
    ];
    workspace = {
      onCreate = {
        default.openFiles = [ "README.md" ];
      };
    };
    previews = {
      enable = false;
      previews = {};
    };
  };
}