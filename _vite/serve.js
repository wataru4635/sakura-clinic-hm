import chokidar from "chokidar";
import path from "path";
import { fileURLToPath } from "url";
import { spawn } from "child_process";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const jsDir = path.join(__dirname, "src", "js");

let buildProcess = null;

function startBuild() {
  if (buildProcess) {
    buildProcess.kill();
    buildProcess = null;
  }
  buildProcess = spawn("npx", ["vite", "build", "--watch"], {
    cwd: __dirname,
    stdio: "inherit",
    shell: true,
  });
  buildProcess.on("close", (code) => {
    buildProcess = null;
  });
  return buildProcess;
}

const viteServer = spawn("npx", ["vite"], {
  cwd: __dirname,
  stdio: "inherit",
  shell: true,
});

const watchImages = spawn("node", ["watch-images.js"], {
  cwd: __dirname,
  stdio: "inherit",
  shell: true,
});

startBuild();

chokidar.watch(jsDir, { ignoreInitial: true }).on("add", (filePath) => {
  if (path.extname(filePath) === ".js") startBuild();
});

function killAll() {
  if (buildProcess) buildProcess.kill();
  viteServer.kill();
  watchImages.kill();
  process.exit();
}

process.on("SIGINT", killAll);
process.on("SIGTERM", killAll);
