import chokidar from "chokidar";
import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";
import { spawn } from "child_process";
import { themeName } from "./theme.config.js";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const SRC_IMG = path.join(__dirname, "src", "images");
const DEST_IMG = path.join(__dirname, "..", themeName, "assets", "images");

function runBuildImages() {
  return new Promise((resolve, reject) => {
    const child = spawn("node", ["build-images.js"], {
      cwd: __dirname,
      stdio: "inherit",
      shell: true,
    });
    child.on("close", (code) => (code === 0 ? resolve() : reject(new Error(`exit ${code}`))));
  });
}

let debounceTimer;
function onChange() {
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => {
    runBuildImages().catch(() => {});
  }, 300);
}

if (!fs.existsSync(SRC_IMG)) {
  fs.mkdirSync(SRC_IMG, { recursive: true });
}

runBuildImages().then(() => {
  const watcher = chokidar.watch(SRC_IMG, {
    ignoreInitial: true,
    ignored: /(^|[/\\])\../,
  });
  watcher.on("add", onChange).on("change", onChange).on("addDir", (dirPath) => {
    const rel = path.relative(SRC_IMG, dirPath);
    if (rel && !rel.startsWith("..")) {
      const destDir = path.join(DEST_IMG, rel);
      fs.mkdirSync(destDir, { recursive: true });
    }
    onChange();
  });
}).catch(() => {});
