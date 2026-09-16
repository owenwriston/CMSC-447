// server.cpp
// A minimal Crow backend that receives the login form data (as JSON)
// and just prints it to the console.
//
// BUILD (after installing Crow + Boost + Asio, see notes below):
//   g++ -std=c++17 server.cpp -o server -lpthread
//
// RUN:
//   ./server
// It will listen on http://localhost:18080

#include "crow_all.h"
using namespace std;

int main() {
    // CORS middleware lets the browser (running on a different port,
    // e.g. a static file server or PHP's built-in server) talk to Crow.
    crow::App<crow::CORSHandler> app;

    auto& cors = app.get_middleware<crow::CORSHandler>();
    cors
        .global()
        .headers("Content-Type")
        .methods("POST"_method, "GET"_method)
        .origin("*"); // for local dev only; lock this down in production

    CROW_ROUTE(app, "/login").methods("POST"_method)
    ([](const crow::request& req) {
        auto body = crow::json::load(req.body);
        if (!body) {
            return crow::response(400, "Invalid JSON");
        }

        string email = body["email"].s();
        string pwd   = body["pwd"].s();

        // <-- this is the "just prints it" part -->
        cout << "Login attempt:\n";
        cout << "  email: " << email << "\n";
        cout << "  pwd:   " << pwd << endl;

        crow::json::wvalue res;
        res["status"] = "received";
        return crow::response{res};
    });

    CROW_ROUTE(app, "/createAccount").methods("POST"_method)
    ([](const crow::request& req) {
        auto body = crow::json::load(req.body);
        if (!body) {
            return crow::response(400, "Invalid JSON");
        }

        string fname   = body["fname"].s();
        string lname   = body["lname"].s();
        string email   = body["email"].s();
        string pwd     = body["pwd"].s();
        string company = body["company"].s();
        string role    = body["role"].s();

        // <-- this is the "just prints it" part -->
        cout << "Create account request:\n";
        cout << "  fname:   " << fname << "\n";
        cout << "  lname:   " << lname << "\n";
        cout << "  email:   " << email << "\n";
        cout << "  pwd:     " << pwd << "\n";
        cout << "  company: " << company << "\n";
        cout << "  role:    " << role << endl;

        crow::json::wvalue res;
        res["status"] = "Account Successfully Created";
        return crow::response{res};
    });


    app.port(8080).multithreaded().run();
}
